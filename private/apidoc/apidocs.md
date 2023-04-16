### BASE_URL

本地BASE_URL：[http://localhost:9526](http://localhost:9526)

测试BASE_URL：

正式BASE_URL：

### Token

#### admin

请求头部Headers或请求参数Params需带上参数：AdminToken（可在配置文件设置）

#### api

请求头部Headers或请求参数Params需带上参数：ApiToken（可在配置文件设置）

### 全局参数

接口调试的时候请在全局参数中设置对应的全局 Header、Query、Body   

### 响应参数

{
  "code": 200,
  "msg": "操作成功",
  "data": {}
}

调试模式异常返回

{
  "code": 500,
  "message": "服务器错误",
  "data": {}
}

### code说明
|code|说明|
|-|-|
|200| 操作成功|
|400| 操作失败，参数错误|
|401| 登录已失效，请重新登录|
|403| 你没有权限操作|
|404| 接口地址错误|
|429| 你的操作过于频繁|
|500| 服务器错误|
|...| ...
