<?php

//接口路由文件

use think\facade\Route;

Route::rule('V1.DiscoverArticle/view', 'V1.DiscoverArticle/view')->middleware(['JwtAuth']);	//DiscoverDiscover详情;
Route::rule('V1.CommunityArticle/index', 'V1.CommunityArticle/index')->middleware(['JwtAuth']);	//CommunityCommunity列表;
Route::rule('V1.CommunityArticle/add', 'V1.CommunityArticle/add')->middleware(['JwtAuth']);	//CommunityCommunity新增;
Route::rule('V1.CommunityArticle/update', 'V1.CommunityArticle/update')->middleware(['JwtAuth']);	//CommunityCommunity修改;
Route::rule('V1.CommunityArticle/delete', 'V1.CommunityArticle/delete')->middleware(['JwtAuth']);	//CommunityCommunity删除;
Route::rule('V1.CommunityArticle/view', 'V1.CommunityArticle/view')->middleware(['JwtAuth']);	//CommunityCommunity详情;
Route::rule('V1.DiscoverComment/index', 'V1.DiscoverComment/index')->middleware(['JwtAuth']);	//Discover评论Discover评论列表;
Route::rule('V1.DiscoverComment/add', 'V1.DiscoverComment/add')->middleware(['JwtAuth']);	//Discover评论Discover评论;
Route::rule('V1.MemberCollect/addAndRemove', 'V1.MemberCollect/addAndRemove')->middleware(['JwtAuth']);	//会员收藏添加or取消收藏;
Route::rule('V1.MemberCollect/index', 'V1.MemberCollect/index')->middleware(['JwtAuth']);	//会员收藏首页数据列表;
Route::rule('V1.MemberLike/addAndRemove', 'V1.MemberLike/addAndRemove')->middleware(['JwtAuth']);	//会员点赞添加or取消点赞;
Route::rule('V1.MemberFollow/addAndRemove', 'V1.MemberFollow/addAndRemove')->middleware(['JwtAuth']);	//会员关注关系关注or取消关注用户;
Route::rule('V1.CommunityComment/index', 'V1.CommunityComment/index')->middleware(['JwtAuth']);	//Community评论Community评论列表;
Route::rule('V1.CommunityComment/add', 'V1.CommunityComment/add')->middleware(['JwtAuth']);	//Community评论Community评论;
Route::rule('V1.QuestionAnswer/myList', 'V1.QuestionAnswer/myList')->middleware(['JwtAuth']);	//QA问题_回答QA问题_我的回答;
Route::rule('V1.QuestionAnswer/list', 'V1.QuestionAnswer/list')->middleware(['JwtAuth']);	//QA问题_回答QA问题_我的回答;
Route::rule('V1.Question/index', 'V1.Question/index')->middleware(['JwtAuth']);	//QA问题QA问题列表;
Route::rule('V1.Question/myList', 'V1.Question/myList')->middleware(['JwtAuth']);	//QA问题我的_QA问题列表;
Route::rule('V1.Question/add', 'V1.Question/add')->middleware(['JwtAuth']);	//QA问题发布QA问题;
Route::rule('V1.MemberIntegral/index', 'V1.MemberIntegral/index')->middleware(['JwtAuth']);	//会员积分记录首页数据列表;
Route::rule('V1.Question/update', 'V1.Question/update')->middleware(['JwtAuth']);	//QA问题修改;
Route::rule('V1.Question/delete', 'V1.Question/delete')->middleware(['JwtAuth']);	//QA问题删除;
Route::rule('V1.Question/view', 'V1.Question/view')->middleware(['JwtAuth']);	//QA问题QA问题详情;
Route::rule('V1.Member/edit', 'V1.Member/edit')->middleware(['JwtAuth']);	//会员列表个人信息;
Route::rule('V1.Member/update', 'V1.Member/update')->middleware(['JwtAuth']);	//会员列表个人信息修改;
Route::rule('V1.Member/info', 'V1.Member/info')->middleware(['JwtAuth']);	//会员列表用户详情;
Route::rule('V1.Member/permissionStatus', 'V1.Member/permissionStatus')->middleware(['JwtAuth']);	//会员列表个人信息开关;
Route::rule('V1.Member/personal_center', 'V1.Member/personal_center')->middleware(['JwtAuth']);	//会员列表个人中心;
Route::rule('V1.Feedback/save', 'V1.Feedback/save')->middleware(['JwtAuth']);	//意见反馈意见反馈;
Route::rule('V1.PlusMinusInteger/save', 'V1.PlusMinusInteger/save')->middleware(['JwtAuth']);	//增减积分save;
Route::rule('V1.MemberShare/info', 'V1.MemberShare/info')->middleware(['JwtAuth']);	//我的分享详情;
Route::rule('V1.Notification/systemNotification', 'V1.Notification/systemNotification')->middleware(['JwtAuth']);	//消息系统消息;
Route::rule('V1.QuestionAnswer/save', 'V1.QuestionAnswer/save')->middleware(['JwtAuth']);	//QA问题_回答回答问题;
Route::rule('V1.QuestionAnswer/pitchOn', 'V1.QuestionAnswer/pitchOn')->middleware(['JwtAuth']);	//QA问题_回答选择答案;
Route::rule('V1.Notification/read', 'V1.Notification/read')->middleware(['JwtAuth']);	//消息读消息;
Route::rule('V1.Notification/articleNotification', 'V1.Notification/articleNotification')->middleware(['JwtAuth']);	//消息文章消息;
Route::rule('V1.MemberCommunity/list', 'V1.MemberCommunity/list')->middleware(['JwtAuth']);	//我的Community我发布的Community;
Route::rule('V1.MemberCommunity/commentList', 'V1.MemberCommunity/commentList')->middleware(['JwtAuth']);	//我的Community我评论的Community;
Route::rule('V1.Garden/list', 'V1.Garden/list')->middleware(['JwtAuth']);	//花园列表;
Route::rule('V1.Garden/add', 'V1.Garden/add')->middleware(['JwtAuth']);	//花园添加;
Route::rule('V1.Garden/view', 'V1.Garden/view')->middleware(['JwtAuth']);	//花园查看详情;
Route::rule('V1.Garden/edit', 'V1.Garden/edit')->middleware(['JwtAuth']);	//花园编辑;
Route::rule('V1.Garden/update', 'V1.Garden/update')->middleware(['JwtAuth']);	//花园修改;
Route::rule('V1.Garden/delete', 'V1.Garden/delete')->middleware(['JwtAuth']);	//花园删除;
Route::rule('V1.Garden/setRemind', 'V1.Garden/setRemind')->middleware(['JwtAuth']);	//花园设置提醒;
Route::rule('V1.Garden/show_Remind', 'V1.Garden/show_Remind')->middleware(['JwtAuth']);	//花园查看提醒;
Route::rule('V1.Garden/deleteRemind', 'V1.Garden/deleteRemind')->middleware(['JwtAuth']);	//删除提醒;
Route::rule('Base/Upload', 'Base/Upload')->middleware(['JwtAuth']);	//图片上传;
Route::rule('V1.MemberFollow/index', 'V1.MemberFollow/index')->middleware(['JwtAuth']);	//我的关注


