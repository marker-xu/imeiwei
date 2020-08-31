1. 约定
    
    用户登录态，通过header中传递token来验证，token通过/user/login接口获取
    
    返回结构: 
        
        {
            "code": 200,
            "message": "",
            "data": [], //返回结果，可以多种结构
        }
    状态码：200表示成功，102表示普通错误，103表示未登录

2. 用户相关

    2.1 登录接口
    
        path: /user/login
        request:
            code: "c1cef9f80c563ec44f074db981f7a0a7ab1f8088", //微信换取授权的code
            imei: "xxxxx"
        response:
            {
                "code":200,
                "message":"成功",
                "data":{
                    "id":123,
                    "username":"test",
                    "display_name":"kaka",
                    "email":"xucongbin@qutoutiao.net",
                    "phone":"15821950827",
                    "type":0,
                    "company":null,
                    "status":0,
                    "token":"0b42UkltVqSwJ_AXWHRnaceg-1VTVrpwV71Emd-NizrYa7vgiM64gCx_e5ygNMe1uYo"
                }
            }
    
    2.2 获取用户信息
    
        path: /user/info
        header:
            token: "xxx"
        response:
            {
                "code":200,
                "message":"成功",
                "data":{
                    "id":761,
                    "username":"xucongbin",
                    "display_name":"徐从斌",
                    "email":"",
                    "phone":"",
                    "type":0,
                    "head_iamge": "xxx", //头像
                    "invite_code": "xxx", //邀请码
                    "content":{
            
                    },
                    "company":'',
                    "status":0
                }
            }
         
     2.3 获取token
         
         path: /user/token
         header:
             imei: "xxx"
         response:
             {
                 "code":200,
                 "message":"成功",
                 "data":{
                     "token":"0b42UkltVqSwJ_AXWHRnaceg"
                 }
             }   
3. 视频相关

    3.1 视频列表
        
        path: /video/common/list
        request:
            category: 1, //视频分类
            page: 1, //页码
            page_size: 8, //每页记录数
        response:
            {
                "code":200,
                "message":"成功",
                "data":[{
                    "id":123, //视频ID
                    "title":"test", //标题
                    "cover_url":"https://rbv01.ku6.com/wifi/o_1drk8t1fa1hhs15jcg6m1485a87j", //封面地址
                    "video_url":"https://rbv01.ku6.com/wifi/o_1drk8su7q1js9upi15jd1tq91l7ih", //播放地址
                    "author":"kaka", //作者
                    "source_from":3, // 
                    "source_url":'', // 
                    "video_type":0, // 视频类型，0:普通，1:短视频
                    "watch_num":0, // 观看数量
                    "category":1, //视频分类
                }]
            }
                
    3.2 短视频列表
            
        path: /video/short/list
        request:
            category: 1, //视频分类
            page: 1, //页码
            page_size: 4, //每页记录数
        response:
            {
                "code":200,
                "message":"成功",
                "data":[{
                    "id":123, //视频ID
                    "title":"test", //标题
                    "cover_url":"https://rbv01.ku6.com/wifi/o_1drk8t1fa1hhs15jcg6m1485a87j", //封面地址
                    "video_url":"https://rbv01.ku6.com/wifi/o_1drk8su7q1js9upi15jd1tq91l7ih", //播放地址
                    "author":"kaka", //作者
                    "source_from":3, // 
                    "source_url":'', // 
                    "video_type":1, // 视频类型，0:普通，1:短视频
                    "watch_num":0, // 观看数量
                }]
            }
            
    3.3 短视频观看      
        
        path: /video/short/watch
        request:
            video_id: 1, //视频ID
            watch_time: 0, //观看时长
        response:
            {
                "code":200,
                "message":"成功",
                "data":[]
            }
            
    3.4 长视频观看      
            
        path: /video/common/watch
        request:
            video_id: 1, //视频ID
            watch_time: 0, //观看时长
        response:
            {
                "code":200,
                "message":"成功",
                "data":[]
            }
            
    3.5 视频分类      
                
        path: /common/dict
        request:
            type: 'video_category'
            
        response:
            {
                "code":200,
                "message":"成功",
                "data":[
                    {
                        'value': 1,
                        'label': '推荐',
                    }
                ]
            }