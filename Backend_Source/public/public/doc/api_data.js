define({ "api": [
  {
    "type": "get",
    "url": "/Base/captcha",
    "title": "02、图片验证码地址",
    "group": "Base",
    "version": "1.0.0",
    "description": "<p>图片验证码</p>",
    "success": {
      "examples": [
        {
          "title": "01 调用示例",
          "content": "<img src=\"http://xxxx.com/Base/captcha\" onClick=\"this.src=this.src+'?'+Math.random()\" alt=\"点击刷新验证码\">",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Base.php",
    "groupTitle": "Base",
    "name": "GetBaseCaptcha"
  },
  {
    "type": "post",
    "url": "/Base/emailCode",
    "title": "03、发送邮箱验证码",
    "group": "Base",
    "version": "1.0.0",
    "description": "<p>邮箱验证码</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>邮箱 (必填)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回图片地址</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Base.php",
    "groupTitle": "Base",
    "name": "PostBaseEmailcode"
  },
  {
    "type": "post",
    "url": "/Base/upload",
    "title": "01、图片上传",
    "group": "Base",
    "version": "1.0.0",
    "description": "<p>图片上传</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回图片地址</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Base.php",
    "groupTitle": "Base",
    "name": "PostBaseUpload"
  },
  {
    "type": "get",
    "url": "/V1.CommunityArticle/index",
    "title": "01、Community列表",
    "group": "CommunityArticle",
    "version": "1.0.0",
    "description": "<p>Community列表</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "community_cate_id",
            "description": "<p>所属分类</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "search",
            "description": "<p>搜索内容</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "member_id",
            "description": "<p>查询用户的文章</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "   {\n\"community_article_id\": 7,\n\"title\": \"测试1\",\n\"tags\": \"标签1,标签2\",\n\"content\": \"我是内容我是内容我是内容我是内容我是内容我是内容我是内容我是内容我是内容\",\n\"pics\": [\n{\n\"title\": \"\",\n\"url\": \"xxx.jpg\"\n},\n{\n\"title\": \"\",\n\"url\": \"xxx.jpg\"\n}\n],\n\"member_id\": 3,\n\"avatar\": \"/uploads/admin/202101/5ff40b8d7fbd2.jpg\",  头像\n\"nickname\": \"无限的画笔\", 昵称\n\"member_level\": 1, 用户等级\n\"like_sum\": 1, 点赞数\n\"comment_sum\": 0, 评论数\n\"see_sum\": 0,  浏览量\n\"create_time\": 1625828729,\n\"is_like\": true, 是否点赞 true 是 false 否\n\"is_follow\": true  关注\n},",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/CommunityArticle.php",
    "groupTitle": "CommunityArticle",
    "name": "GetV1CommunityarticleIndex"
  },
  {
    "type": "get",
    "url": "/V1.CommunityArticle/view",
    "title": "05、Community详情",
    "group": "CommunityArticle",
    "version": "1.0.0",
    "description": "<p>查看详情</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "community_article_id",
            "description": "<p>主键ID</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/CommunityArticle.php",
    "groupTitle": "CommunityArticle",
    "name": "GetV1CommunityarticleView"
  },
  {
    "type": "post",
    "url": "/V1.CommunityArticle/add",
    "title": "02、Community新增",
    "group": "CommunityArticle",
    "version": "1.0.0",
    "description": "<p>添加</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>标题</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "community_cate_id",
            "description": "<p>所属分类</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "tags",
            "description": "<p>标签</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>内容</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "pics",
            "description": "<p>图片上传</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/CommunityArticle.php",
    "groupTitle": "CommunityArticle",
    "name": "PostV1CommunityarticleAdd"
  },
  {
    "type": "post",
    "url": "/V1.CommunityArticle/delete",
    "title": "04、Community删除",
    "group": "CommunityArticle",
    "version": "1.0.0",
    "description": "<p>删除</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "community_article_id",
            "description": "<p>主键id</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/CommunityArticle.php",
    "groupTitle": "CommunityArticle",
    "name": "PostV1CommunityarticleDelete"
  },
  {
    "type": "post",
    "url": "/V1.CommunityArticle/update",
    "title": "03、Community修改",
    "group": "CommunityArticle",
    "version": "1.0.0",
    "description": "<p>修改</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "community_article_id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>标题</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "community_cate_id",
            "description": "<p>所属分类</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "tags",
            "description": "<p>标签</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>内容</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "pics",
            "description": "<p>图片上传</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/CommunityArticle.php",
    "groupTitle": "CommunityArticle",
    "name": "PostV1CommunityarticleUpdate"
  },
  {
    "type": "get",
    "url": "/V1.CommunityCate/index",
    "title": "01、分类列表",
    "group": "CommunityCate",
    "version": "1.0.0",
    "description": "<p>分类列表</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "is_under",
            "description": "<p>是否推荐栏目 推荐|1,非推荐|0 ,全部|2</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/CommunityCate.php",
    "groupTitle": "CommunityCate",
    "name": "GetV1CommunitycateIndex"
  },
  {
    "type": "get",
    "url": "/V1.CommunityComment/index",
    "title": "01、Community评论列表",
    "group": "CommunityComment",
    "version": "1.0.0",
    "description": "<p>Community评论列表</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "community_article_id",
            "description": "<p>文章id</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "pid",
            "description": "<p>父级评论id 查看二级回复传入</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/CommunityComment.php",
    "groupTitle": "CommunityComment",
    "name": "GetV1CommunitycommentIndex"
  },
  {
    "type": "post",
    "url": "/V1.CommunityComment/add",
    "title": "02、Community评论",
    "group": "CommunityComment",
    "version": "1.0.0",
    "description": "<p>添加</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "community_article_id",
            "description": "<p>文章id</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>评论内容</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "pid",
            "description": "<p>父级id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/CommunityComment.php",
    "groupTitle": "CommunityComment",
    "name": "PostV1CommunitycommentAdd"
  },
  {
    "type": "get",
    "url": "/Config/list",
    "title": "01、list",
    "group": "Config",
    "version": "1.0.0",
    "description": "<p>list</p>",
    "parameter": {
      "fields": {
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Config.php",
    "groupTitle": "Config",
    "name": "GetConfigList"
  },
  {
    "type": "get",
    "url": "/V1.ConfigMemberInteger/index",
    "title": "01、列表",
    "group": "ConfigMemberInteger",
    "version": "1.0.0",
    "description": "<p>列表</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/ConfigMemberInteger.php",
    "groupTitle": "ConfigMemberInteger",
    "name": "GetV1ConfigmemberintegerIndex"
  },
  {
    "type": "get",
    "url": "/V1.DiscoverArticle/index",
    "title": "01、Discover列表",
    "group": "DiscoverArticle",
    "version": "1.0.0",
    "description": "<p>Discover列表</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "discover_cate_id",
            "description": "<p>所属分类</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "search",
            "description": "<p>搜索关键字</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "member_id",
            "description": "<p>查询用户的文章</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/DiscoverArticle.php",
    "groupTitle": "DiscoverArticle",
    "name": "GetV1DiscoverarticleIndex"
  },
  {
    "type": "get",
    "url": "/V1.DiscoverArticle/view",
    "title": "02、Discover详情",
    "group": "DiscoverArticle",
    "version": "1.0.0",
    "description": "<p>Discover详情</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "discover_article_id",
            "description": "<p>主键ID</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/DiscoverArticle.php",
    "groupTitle": "DiscoverArticle",
    "name": "GetV1DiscoverarticleView"
  },
  {
    "type": "get",
    "url": "/V1.DiscoverCate/index",
    "title": "01、Discover分类",
    "group": "DiscoverCate",
    "version": "1.0.0",
    "description": "<p>Discover分类</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/DiscoverCate.php",
    "groupTitle": "DiscoverCate",
    "name": "GetV1DiscovercateIndex"
  },
  {
    "type": "get",
    "url": "/V1.DiscoverComment/index",
    "title": "01、Discover评论列表",
    "group": "DiscoverComment",
    "version": "1.0.0",
    "description": "<p>Discover评论列表</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "discover_article_id",
            "description": "<p>文章id</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "pid",
            "description": "<p>父级评论id 查看二级回复传入</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\n   \"discover_comment_id\": 6, 评论id\n   \"member_id\": 3,  用户id\n   \"discover_article_id\": 1,\n   \"avatar\": \"/uploads/admin/202101/5ff40b8d7fbd2.jpg\", 头像\n   \"nickname\": \"无限的画笔\", 昵称\n   \"to_member_id\": 0,  回复对象id\n   \"content\": \"评论一下\",\n   \"to_nickname\": \"\",   回复对象昵称\n   \"create_time\": 1626062513,\n   \"like_sum\": 1,      点赞数量\n   \"back_sum\": 0,      回复数量\n\n   \"is_like\": true\n   },",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/DiscoverComment.php",
    "groupTitle": "DiscoverComment",
    "name": "GetV1DiscovercommentIndex"
  },
  {
    "type": "post",
    "url": "/V1.DiscoverComment/add",
    "title": "02、Discover评论",
    "group": "DiscoverComment",
    "version": "1.0.0",
    "description": "<p>添加</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "discover_article_id",
            "description": "<p>文章id</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>评论内容</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "pid",
            "description": "<p>父级id 可空</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/DiscoverComment.php",
    "groupTitle": "DiscoverComment",
    "name": "PostV1DiscovercommentAdd"
  },
  {
    "type": "post",
    "url": "/V1.Feedback/save",
    "title": "01、意见反馈",
    "group": "Feedback",
    "version": "1.0.0",
    "description": "<p>创建数据</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "body",
            "description": "<p>反馈内容 (必填)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Feedback.php",
    "groupTitle": "Feedback",
    "name": "PostV1FeedbackSave"
  },
  {
    "type": "delete",
    "url": "/V1.Garden/delete",
    "title": "05、删除",
    "group": "Garden",
    "version": "1.0.0",
    "description": "<p>删除数据</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "ids",
            "description": "<p>主键id 注意后面跟了s 多数据删除</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Garden.php",
    "groupTitle": "Garden",
    "name": "DeleteV1GardenDelete"
  },
  {
    "type": "get",
    "url": "/V1.Garden/edit",
    "title": "03、编辑",
    "group": "Garden",
    "version": "1.0.0",
    "description": "<p>编辑</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Garden.php",
    "groupTitle": "Garden",
    "name": "GetV1GardenEdit"
  },
  {
    "type": "get",
    "url": "/V1.Garden/list",
    "title": "01、列表",
    "group": "Garden",
    "version": "1.0.0",
    "description": "<p>列表</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Garden.php",
    "groupTitle": "Garden",
    "name": "GetV1GardenList"
  },
  {
    "type": "get",
    "url": "/V1.Garden/show_Remind",
    "title": "07、查看提醒",
    "group": "Garden",
    "version": "1.0.0",
    "description": "<p>查看提醒</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Garden.php",
    "groupTitle": "Garden",
    "name": "GetV1GardenShow_remind"
  },
  {
    "type": "post",
    "url": "/V1.Garden/add",
    "title": "02、添加",
    "group": "Garden",
    "version": "1.0.0",
    "description": "<p>创建数据</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "common_name",
            "description": "<p>common_name</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>member_id (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "plant_name",
            "description": "<p>plant_name (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "plant_introduction",
            "description": "<p>plant_introduction</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "duration",
            "description": "<p>duration</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "flower_color",
            "description": "<p>flower_color</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "fertilization",
            "description": "<p>fertilization</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "water",
            "description": "<p>water</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "exposure",
            "description": "<p>exposure</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "soil",
            "description": "<p>soil</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "minimum_tempature",
            "description": "<p>minimum_tempature</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "blooming",
            "description": "<p>blooming</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "update_time",
            "description": "<p>update_time</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "img",
            "description": "<p>img (必填)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Garden.php",
    "groupTitle": "Garden",
    "name": "PostV1GardenAdd"
  },
  {
    "type": "post",
    "url": "/V1.Garden/setRemind",
    "title": "06、设置提醒",
    "group": "Garden",
    "version": "1.0.0",
    "description": "<p>编辑数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>member_id (必填)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Garden.php",
    "groupTitle": "Garden",
    "name": "PostV1GardenSetremind"
  },
  {
    "type": "post",
    "url": "/V1.Garden/update",
    "title": "04、修改",
    "group": "Garden",
    "version": "1.0.0",
    "description": "<p>编辑数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "common_name",
            "description": "<p>common_name</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>member_id (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "plant_name",
            "description": "<p>plant_name (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "plant_introduction",
            "description": "<p>plant_introduction</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "duration",
            "description": "<p>duration</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "flower_color",
            "description": "<p>flower_color</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "fertilization",
            "description": "<p>fertilization</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "water",
            "description": "<p>water</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "exposure",
            "description": "<p>exposure</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "soil",
            "description": "<p>soil</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "minimum_tempature",
            "description": "<p>minimum_tempature</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "blooming",
            "description": "<p>blooming</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "create_time",
            "description": "<p>create_time</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "update_time",
            "description": "<p>update_time</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "img",
            "description": "<p>img (必填)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Garden.php",
    "groupTitle": "Garden",
    "name": "PostV1GardenUpdate"
  },
  {
    "type": "get",
    "url": "/V1.IntegerShop/info",
    "title": "01、积分商城内容",
    "group": "IntegerShop",
    "version": "1.0.0",
    "description": "<p>积分商城内容</p>",
    "parameter": {
      "fields": {
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/IntegerShop.php",
    "groupTitle": "IntegerShop",
    "name": "GetV1IntegershopInfo"
  },
  {
    "type": "get",
    "url": "/V1.MemberCollect/index",
    "title": "01、我的收藏",
    "group": "MemberCollect",
    "version": "1.0.0",
    "description": "<p>Discover列表</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "discover_cate_id",
            "description": "<p>所属分类</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "type",
            "description": "<p>类型 (1 discover 2 community 3qa)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "sort",
            "description": "<p>QA排序</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/MemberCollect.php",
    "groupTitle": "MemberCollect",
    "name": "GetV1MembercollectIndex"
  },
  {
    "type": "post",
    "url": "/V1.MemberCollect/addAndRemove",
    "title": "02、添加or取消收藏",
    "group": "MemberCollect",
    "version": "1.0.0",
    "description": "<p>添加</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>类型 discover|1,community|2,qa|3</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "object_id",
            "description": "<p>对象id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/MemberCollect.php",
    "groupTitle": "MemberCollect",
    "name": "PostV1MembercollectAddandremove"
  },
  {
    "type": "get",
    "url": "/V1.MemberCommunity/commentList",
    "title": "02、我评论的Community",
    "group": "MemberCommunity",
    "version": "1.0.0",
    "description": "<p>我评论的Community</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/MemberCommunity.php",
    "groupTitle": "MemberCommunity",
    "name": "GetV1MembercommunityCommentlist"
  },
  {
    "type": "get",
    "url": "/V1.MemberCommunity/list",
    "title": "01、我发布的Community",
    "group": "MemberCommunity",
    "version": "1.0.0",
    "description": "<p>我发布的Community</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/MemberCommunity.php",
    "groupTitle": "MemberCommunity",
    "name": "GetV1MembercommunityList"
  },
  {
    "type": "get",
    "url": "/V1.MemberFollow/index",
    "title": "01、首页数据列表",
    "group": "MemberFollow",
    "version": "1.0.0",
    "description": "<p>首页数据列表</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "fans",
            "description": "<p>1 我的关注 0我的粉丝</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "search",
            "description": "<p>搜索</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/MemberFollow.php",
    "groupTitle": "MemberFollow",
    "name": "GetV1MemberfollowIndex"
  },
  {
    "type": "post",
    "url": "/V1.MemberFollow/addAndRemove",
    "title": "02、关注or取消关注用户",
    "group": "MemberFollow",
    "version": "1.0.0",
    "description": "<p>添加</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "follow_member_id",
            "description": "<p>关注对象id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/MemberFollow.php",
    "groupTitle": "MemberFollow",
    "name": "PostV1MemberfollowAddandremove"
  },
  {
    "type": "get",
    "url": "/V1.Member/edit",
    "title": "03、个人信息展示",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>个人信息</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Member.php",
    "groupTitle": "Member",
    "name": "GetV1MemberEdit"
  },
  {
    "type": "get",
    "url": "/V1.Member/info",
    "title": "05、用户详情",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>用户详情</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Member.php",
    "groupTitle": "Member",
    "name": "GetV1MemberInfo"
  },
  {
    "type": "get",
    "url": "/V1.Member/personal_center",
    "title": "08、个人中心",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>个人中心</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Member.php",
    "groupTitle": "Member",
    "name": "GetV1MemberPersonal_center"
  },
  {
    "type": "get",
    "url": "/V1.MemberIntegral/index",
    "title": "01、首页数据列表",
    "group": "MemberIntegral",
    "version": "1.0.0",
    "description": "<p>首页数据列表</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/MemberIntegral.php",
    "groupTitle": "MemberIntegral",
    "name": "GetV1MemberintegralIndex"
  },
  {
    "type": "get",
    "url": "/V1.MemberLike/index",
    "title": "01、首页数据列表",
    "group": "MemberLike",
    "version": "1.0.0",
    "description": "<p>首页数据列表</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/MemberLike.php",
    "groupTitle": "MemberLike",
    "name": "GetV1MemberlikeIndex"
  },
  {
    "type": "post",
    "url": "/V1.MemberLike/addAndRemove",
    "title": "02、添加or取消点赞",
    "group": "MemberLike",
    "version": "1.0.0",
    "description": "<p>添加</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>类型 discover|1,community|2,qa|3,discover评论|4,community评论|5,qa评论|6</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "object_id",
            "description": "<p>对象id</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/MemberLike.php",
    "groupTitle": "MemberLike",
    "name": "PostV1MemberlikeAddandremove"
  },
  {
    "type": "post",
    "url": "/V1.Member/emailLogin",
    "title": "02、邮箱登录",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>账号密码登录</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>登录用户名</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>登录密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\n\"status\": \"200\",\n\"msg\": \"登陆成功\",\n\"data\": {\n\"member_id\": \"3\",\n\"nickname\": \"无限的画笔\",\n\"sex\": \"1\",\n\"mobile\": \"\",\n\"email\": \"790353029@qq.com\",\n\"avatar\": \"/uploads/admin/202101/5ff40b8d7fbd2.jpg\",\n\"status\": \"1\",\n\"create_time\": \"1625802137\",\n\"area\": \"\",\n\"human_desc\": \"\",\n\"all_integral\": \"0\",\n\"integral\": \"0\",\n\"member_level\": \"1\",\n\"member_level_exp\": \"0\",\n\"member_permission_status\": \"0\",\n\"follows\": 0,       关注数量\n\"fans\": 0           粉丝数量\n},\n\"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJjbGllbnQueGhhZG1pbiIsImF1ZCI6InNlcnZlci54aGFkbWluIiwiaWF0IjoxNjI1ODAzNTA4LCJleHAiOjE2MjU4MTA3MDgsInVpZCI6IjMifQ.d9MuV-pupJzWzJIbdOGPQgskdknrxKGmcHEMW3DGE2Y\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Member.php",
    "groupTitle": "Member",
    "name": "PostV1MemberEmaillogin"
  },
  {
    "type": "post",
    "url": "/V1.Member/permissionStatus",
    "title": "06、个人信息开关",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>编辑数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "member_permission_status",
            "description": "<p>个人信息开关 开启|1,关闭|0</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Member.php",
    "groupTitle": "Member",
    "name": "PostV1MemberPermissionstatus"
  },
  {
    "type": "post",
    "url": "/V1.Member/register",
    "title": "01、注册账户",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>创建数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>邮箱 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>验证码 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "re_password",
            "description": "<p>重复密码 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "invitation_code",
            "description": "<p>邀请码 (选填)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": " {\n\"status\": \"200\",\n\"msg\": \"操作成功\",\n\"data\": {\n\"avatar\": \"/uploads/admin/202101/5ff40b8d7fbd2.jpg\", 头像\n\"nickname\": \"无限的画笔\", 昵称\n\"email\": \"790353029@qq.com\",\n\"sex\": 1, 性别 1男 2女\n\"mobile\": \"\", 手机号\n\"area\": \"\", 地区\n\"human_desc\": \"\", 自我介绍\n\"status\": 1, 状态 1 开启 0禁用\n\"create_time\": 1625802137, 创建时间\n\"integral\": 0, 积分\n\"all_integral\": 0, 累计积分\n\"member_level\": 1, 等级\n\"member_level_exp\": 0, 当前等级经验\n\"member_permission_status\": 0  个人信息可见  1开启 0关闭\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Member.php",
    "groupTitle": "Member",
    "name": "PostV1MemberRegister"
  },
  {
    "type": "post",
    "url": "/V1.Member/resetPassword",
    "title": "07、修改密码",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>编辑数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>邮箱验证码 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>邮箱 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "re_password",
            "description": "<p>密码 (必填)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Member.php",
    "groupTitle": "Member",
    "name": "PostV1MemberResetpassword"
  },
  {
    "type": "post",
    "url": "/V1.Member/update",
    "title": "04、个人信息修改",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>编辑数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "avatar",
            "description": "<p>头像 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "nickname",
            "description": "<p>用户昵称 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "sex",
            "description": "<p>性别 (必填) 男|1|success,女|2|warning</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "area",
            "description": "<p>地区</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "human_desc",
            "description": "<p>我的简介</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Member.php",
    "groupTitle": "Member",
    "name": "PostV1MemberUpdate"
  },
  {
    "type": "get",
    "url": "/V1.MemberShare/info",
    "title": "01、详情",
    "group": "MemberShare",
    "version": "1.0.0",
    "description": "<p>详情</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/MemberShare.php",
    "groupTitle": "MemberShare",
    "name": "GetV1MembershareInfo"
  },
  {
    "type": "get",
    "url": "/V1.Notification/articleNotification",
    "title": "02、文章消息",
    "group": "Notification",
    "version": "1.0.0",
    "description": "<p>文章消息</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认10,会×2）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Notification.php",
    "groupTitle": "Notification",
    "name": "GetV1NotificationArticlenotification"
  },
  {
    "type": "get",
    "url": "/V1.Notification/read",
    "title": "03、读消息",
    "group": "Notification",
    "version": "1.0.0",
    "description": "<p>编辑数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>文章类型 (必填 1 community 2 qa 3系统)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Notification.php",
    "groupTitle": "Notification",
    "name": "GetV1NotificationRead"
  },
  {
    "type": "get",
    "url": "/V1.Notification/systemNotification",
    "title": "01、系统消息",
    "group": "Notification",
    "version": "1.0.0",
    "description": "<p>系统消息</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Notification.php",
    "groupTitle": "Notification",
    "name": "GetV1NotificationSystemnotification"
  },
  {
    "type": "post",
    "url": "/V1.PlusMinusInteger/save",
    "title": "01、加减积分",
    "group": "PlusMinusInteger",
    "version": "1.0.0",
    "description": "<p>创建数据</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>type (必填) 1 增加 2减少</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/PlusMinusInteger.php",
    "groupTitle": "PlusMinusInteger",
    "name": "PostV1PlusminusintegerSave"
  },
  {
    "type": "get",
    "url": "/V1.QuestionAnswer/myList",
    "title": "01、QA问题_我的回答",
    "group": "QuestionAnswer",
    "version": "1.0.0",
    "description": "<p>QA问题_我的回答</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/QuestionAnswer.php",
    "groupTitle": "QuestionAnswer",
    "name": "GetV1QuestionanswerMylist"
  },
  {
    "type": "post",
    "url": "/V1.QuestionAnswer/pitchOn",
    "title": "03、选择答案",
    "group": "QuestionAnswer",
    "version": "1.0.0",
    "description": "<p>编辑数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "question_answer_id",
            "description": "<p>主键ID (必填)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/QuestionAnswer.php",
    "groupTitle": "QuestionAnswer",
    "name": "PostV1QuestionanswerPitchon"
  },
  {
    "type": "post",
    "url": "/V1.QuestionAnswer/save",
    "title": "02、回答问题",
    "group": "QuestionAnswer",
    "version": "1.0.0",
    "description": "<p>创建数据</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "question_id",
            "description": "<p>问题id (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>回答内容 (必填)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/QuestionAnswer.php",
    "groupTitle": "QuestionAnswer",
    "name": "PostV1QuestionanswerSave"
  },
  {
    "type": "get",
    "url": "/V1.QuestionCate/index",
    "title": "01、QA分类列表",
    "group": "QuestionCate",
    "version": "1.0.0",
    "description": "<p>QA分类列表</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "is_under",
            "description": "<p>是否推荐栏目 开启|1,关闭|0</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/QuestionCate.php",
    "groupTitle": "QuestionCate",
    "name": "GetV1QuestioncateIndex"
  },
  {
    "type": "get",
    "url": "/V1.Question/index",
    "title": "01、QA问题列表",
    "group": "Question",
    "version": "1.0.0",
    "description": "<p>QA问题列表</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "question_cate_id",
            "description": "<p>所属分类</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "sort",
            "description": "<p>0|默认,1|最新,2|高分,3|已解决</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "content",
            "description": "<p>搜索内容</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Question.php",
    "groupTitle": "Question",
    "name": "GetV1QuestionIndex"
  },
  {
    "type": "get",
    "url": "/V1.Question/myList",
    "title": "06、QA问题_我的问题",
    "group": "Question",
    "version": "1.0.0",
    "description": "<p>我的_QA问题列表</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Question.php",
    "groupTitle": "Question",
    "name": "GetV1QuestionMylist"
  },
  {
    "type": "get",
    "url": "/V1.Question/view",
    "title": "05、QA问题详情",
    "group": "Question",
    "version": "1.0.0",
    "description": "<p>查看详情</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "question_id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Question.php",
    "groupTitle": "Question",
    "name": "GetV1QuestionView"
  },
  {
    "type": "post",
    "url": "/V1.Question/add",
    "title": "02、发布QA问题",
    "group": "Question",
    "version": "1.0.0",
    "description": "<p>添加</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>标题 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "question_cate_id",
            "description": "<p>所属分类 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>问题内容 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "pics",
            "description": "<p>图片</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "integer_sum",
            "description": "<p>积分设置</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Question.php",
    "groupTitle": "Question",
    "name": "PostV1QuestionAdd"
  },
  {
    "type": "post",
    "url": "/V1.Question/delete",
    "title": "04、删除",
    "group": "Question",
    "version": "1.0.0",
    "description": "<p>删除</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "question_ids",
            "description": "<p>主键id 注意后面跟了s 多数据删除</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Question.php",
    "groupTitle": "Question",
    "name": "PostV1QuestionDelete"
  },
  {
    "type": "post",
    "url": "/V1.Question/update",
    "title": "03、修改",
    "group": "Question",
    "version": "1.0.0",
    "description": "<p>修改</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "question_id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "member_id",
            "description": "<p>member_id</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>标题 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>问题内容 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "pic",
            "description": ""
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "integer_sum",
            "description": "<p>积分设置</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "create_time",
            "description": "<p>创建时间</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "like_sum",
            "description": "<p>点赞数量</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "answer_sum",
            "description": "<p>回答数量</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "see_sum",
            "description": "<p>浏览量</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "question_cate_id",
            "description": "<p>所属分类 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_status",
            "description": "<p>审核状态 通过|1|success,未通过|0|danger,未审核|2|warning</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "status",
            "description": "<p>状态 开启|1,关闭|0</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "auth_msg",
            "description": "<p>审核消息</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "cate_name",
            "description": "<p>分类名称</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/V1/Question.php",
    "groupTitle": "Question",
    "name": "PostV1QuestionUpdate"
  }
] });
