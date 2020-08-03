<?php
namespace common\library;

use OSS\Core\OssException;
use yii\base\Component;
use OSS\OssClient;
use yii\helpers\Json;
use Yii;

/**
 * Class Aliyunoss
 * @package common\library
 * @desc: Aliyunoss
 * @name: Aliyunoss
 * @date 2019/11/58:40 PM
 */
class Aliyunoss extends Component
{
    public $accessKeyId;
    public $accessKeySecret;
    public $endPoint;

    public $endPointIn;
    public $bucket;
    public $baseUrl;
    public $pathPrefix;

    /**
     * @var OssClient
     */
    public $oss;

    /**
     * @var string
     */
    protected $currentSpan;

    /**
     * trace 服务名称
     * @var string
     */
    protected $traceServiceName = '';

    /**
     * Aliyunoss constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (isset(Yii::$app->params['oss']))
        {
            $ossConfig = Yii::$app->params['oss'];
            $this->accessKeyId = $ossConfig['access_key_id'];
            $this->accessKeySecret = $ossConfig['access_key_secret'];
            $this->endPoint = $ossConfig['end_point'];
            $this->bucket = $ossConfig['bucket'];
            $this->pathPrefix = $ossConfig['path_prefix'];
        }
        parent::__construct($config);
    }

    /**
     * @throws OssException
     */
    public function init()
    {
        $this->oss = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endPoint);
        $this->baseUrl = 'http://' . $this->bucket . '.' . $this->endPoint . '/' . $this->pathPrefix;

        $this->traceServiceName = Yii::$app->params['trace_service_name'];
    }

    /**
     * 上传本地文件
     * @param string $object object名称
     * @param string $file 本地文件路径
     * @return null
     * @throws OssException
     */
    public function uploadFile($object, $file)
    {
        $this->preTrace('uploadFile');
        $object = $this->pathPrefix . $object;
        $res = $this->oss->uploadFile($this->bucket, $object, $file);
        $this->postTrace();
        return $res;
    }

    /**
     * @param string $object
     * @return string
     */
    public function getFileUrl($object)
    {
        return $this->baseUrl . $object;
    }

    /**
     * 上传内存中的内容
     * @param $object
     * @param $content
     * @return null
     */
    public function putObject($object, $content)
    {
        $this->preTrace('putObject');
        $object = $this->pathPrefix . $object;
        $res = $this->oss->putObject($this->bucket, $object, $content);
        $this->postTrace();
        return $res;
    }

    /**
     * 获取内存中的内容
     * @param $object
     * @return string
     */
    public function getObject($object)
    {
        $this->preTrace('getObject');
        $object = $this->pathPrefix . $object;
        $res = $this->oss->getObject($this->bucket, $object);
        $this->postTrace();
        return $res;
    }

    /**
     * 上传内存中的内容
     * @param $object
     * @return boolean
     */
    public function doesObjectExist($object)
    {
        $this->preTrace('doesObjectExist');
        $object = $this->pathPrefix . $object;
        $res = $this->oss->doesObjectExist($this->bucket, $object);
        $this->postTrace();
        return $res;
    }

    /**
     * @param $fileName
     * @param $fileType
     * @param $file
     * @param string $filePah
     * @return array|string
     */
    public function upload($fileName, $fileType, $file, $filePah = '')
    {
        Yii::info(func_get_args(), __METHOD__);
        return $this->write($file, $fileType, $filePah);
    }

    /**
     * @param $fileName
     * @param $fileType
     * @param $file
     * @param string $filePah
     * @return array|string
     */
    public function uploadByBackend($fileName, $fileType, $file, $filePah = '')
    {
        Yii::info(func_get_args(), __METHOD__);
        if (!$filePah) {
            $filePah = date('Ym') . '/';
        }

        $filePah = 'backend/' . $filePah;
        return $this->write($file, $fileType, $filePah);
    }

    /**
     * @param $file
     * @param $fileType
     * @param $filePah
     * @param bool $base64
     * @return array|string
     */
    public function write($file, $fileType, $filePah, $base64 = true)
    {
        $fileName = md5(time() . mt_rand(10, 99)) . "." . $fileType;
        if ($base64 === true) {
            $data = base64_decode($file);
        } else {
            $data = $file;
        }

        if (!$filePah) {
            $filePah = date('Ym') . '/';
        }

        $object = $this->pathPrefix . $filePah . $fileName;
        try {
            $this->oss->putObject($this->bucket, $object, $data);
            if (Yii::$app->controller->id == 'file' && Yii::$app->controller->action->id == 'sound-upload') {
                $mp3 = md5(time() . mt_rand(10, 99)) . ".mp3";
                Yii::$app->oss_media->change($this->pathPrefix . $filePah . $fileName, $this->pathPrefix . $filePah . $mp3);
                return ['first' => $this->baseUrl . $filePah . $fileName, 'change' => $this->baseUrl . $filePah . $mp3];
            }
            return $this->baseUrl . $filePah . $fileName;
        } catch (OssException $e) {
            echo Json::encode(['code' => $e->getCode(), 'message' => $e->getMessage()]);
            exit;
        }
    }

    /**
     *
     * @param string $method
     * @return void
     */
    protected function preTrace($method)
    {
        $this->currentSpan  = null;
        $url                = $this->baseUrl . '/' . $method;
        $tmp                = parse_url($url);
        $header             = array();
        $spanName           = 'http_sendRequest/' . $tmp['host'] . $tmp['path'];
        $this->currentSpan  = $spanName;
        Yii::info('start, span-' . $spanName . ',header-' . json_encode($header), __METHOD__);
    }

    /**
     * @return void
     */
    protected function postTrace()
    {
//        $this->currentSpan->setTag(Tags::HTTP_STATUS_CODE, 200);

        // 操作失败的情况，设置error信息
//        if ($status != 200)
//        {
//            $span->setTag(Tags::ERROR, 1);
//            $span->logsKV(Tags::MESSAGE, 'request fail');
//        }

//        $this->currentSpan->finish();

        Yii::info('end, span-' . $this->currentSpan, __METHOD__);
    }

    /**
     * @param string $fileName
     * @param string $type
     * @return string
     */
    public static function buildObject($fileName, $type = 'common')
    {
        return date("Ymd").'/' . $type.'/' . $fileName;
    }

}
