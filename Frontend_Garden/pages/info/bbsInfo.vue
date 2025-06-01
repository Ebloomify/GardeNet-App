<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<u-navbar :title="pageTitle" :border-bottom="true">
			<view slot="right" class="fz36 c3 pr30" v-if="info" @click="collection">
				<view class="iconshoucang c9" :class="{'ca': info.iscollect == 1}"></view>
			</view>
		</u-navbar>
		<view class="fz28 ca tac">分类名称</view>
		<!--  -->
		<view v-if="info">
			<view class="p30">
				<view class="title fz38 c3">标题</view>
				<view class="h30"></view>
				<!-- 视频 -->
				<view class="mb20" v-if="info.video">
					<video :src="$r.imgUrl + info.video" style="width: 100%;"></video>
				</view>
				<!-- QA的积分模板  已完成的状态 -->
				<view v-if="param && param.fromType == 'qa'">
					<!-- 进行中 -->
					<view class="flex itc mb20" v-if="info.data.taskstatus == 0">
						<view class="mr10">
							<image src="../../static/images/qa1.jpg" mode="" class="jifen"></image>
						</view>
						<view class="fz26" style="color: #ffd03a;">{{info.data.price}}</view>
						<view class="fz24 pl10 c9">{{getClassName(info.data.groupid)}}</view>
					</view>
					<!-- 已完成 -->
					<view class="flex itc mb20" v-else>
						<view class="mr10">
							<image src="../../static/images/qa2.jpg" mode="" class="jifen"></image>
						</view>
						<view class="fz26 ca">Resolved</view>
					</view>
				</view>
				<!-- bbs和qa需要关注模板 -->
				<view v-if="param && param.fromType != 'discover'">
					<view class="">
						<view class="flex itc mb20">
							<view class=" mr20">
								<image :src="url + info.data.userpic" mode="widthFix" class="avt"></image>
							</view>
							<view class="flex_1 fz30 mr20 c3">
								<view class="flex itc">
									<view class=" oh1 mr20">{{info.data.nickname}}</view>
									<view class="level flex_1">
										<image :src="`../../static/images/l${info.data.vipid}.png`" mode="widthFix"
											:class="'l'+info.data.vipid"></image>
									</view>
								</view>
								<view class="fz24 c9">{{info.data.addtime}}</view>
							</view>
							<!-- 关注 -->
							<view>
								<view class="follow_btn flex itc juc " :class="{'btn_bg' : info.data.isfollow == 0}"
									@click.stop="followFn('follow')">
									<view class="iconjia cf fz18 mr5" v-if="info.data.isfollow == 0"></view>
									<view class="fz28 cf">{{info.data.isfollow == 0 ? 'follow' : 'following'}}</view>
								</view>
							</view>
						</view>
					</view>
				</view>

				<!-- 新闻内容 -->
				<view class="newInfo_box">
					<!-- 标签 -->
					<view class="flex oh itc flex_warp">
						<view class="tag fz22 ca" v-for="item in tags(info.data.tags)" v-if="item">{{item}}</view>
					</view>
					<view class="fz30 c3 lh50">
						<u-parse :html="info.data.description"></u-parse>
					</view>
					<!--  -->
					<image :src="url + item" mode="widthFix" style="width: 100%;" v-if="item"
						v-for="item in getPic(info.data.pics)"></image>
				</view>
				<!-- 评论 -->
				<view v-if="info.comment && param.fromType != 'discover'">
					<view class="fz34 c3 lh100 fw9" v-if="param.fromType == 'qa'">So the Answers</view>
					<view class="fz34 c3 lh100 fw9" v-else>Comments</view>
					<commentList :info="info" :list="info.comment" :fromType="param.fromType" :showConfirm="showConfirm"
						@infoOperation="commentOperation" :statuc="info.data.taskstatus"></commentList>
				</view>
				<!-- 底部输入框 -->
				<view class="footer">
					<view class="h100"></view>
					<view class="footer_box ">
						<view class="flex p0_30 itc h100">
							<view class="inp fz24 c9 flex_1 mr20" v-if="param && param.fromType != 'discover'"
								@click="showCom">Say something</view>
							<view class="icondianzan fz40 c9" :class="{'ca' : info.data.islike == 1}" @click="give">
							</view>
							<view class="fz20 c9 ml10" @click="give">{{info.data.likenum}}</view>
							<view class="ml30 iconshanchu ca" v-if="info.data.userid == userInfo.member.ID"
								@click="delInfo(info.data.id)"></view>
						</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 评论层 -->
		<u-mask :show="show" @click="show = false" z-index="10073"></u-mask>
		<view class="commentBox bgf trans" :class="{'showCommentBox' :show }">
			<view class="commentTiele flex h100 itc bb1">
				<view class="flex_1"></view>
				<view class="fz40 c3 iconguanbi tac" style="width: 100rpx;" @click="show = false"></view>
			</view>
			<!--  -->
			<view class="p30">
				<textarea maxlength="-1" value="" placeholder="Say something" class="fz26 c3" v-model="desc"></textarea>
			</view>
			<!--  -->
			<view class="flex p0_30">
				<view class="flex_1"></view>
				<view class="sub_btn tac fz26 cf tac bga" @click="submit">submit</view>
			</view>
		</view>
		<!-- 所有评论数据 -->
		<u-mask :show="showCommentDetails" @click="showCommentDetails = false"></u-mask>
		<view class="allComment_box trans" :style="{'top':offSetTop+'px'}"
			:class="{'allComment_box_active' : showCommentDetails}" @click="showCommentDetails = false">
			<scroll-view scroll-y="true" style="height: 100%;">
				<view class="flex h90 itc bb1">
					<view style="width: 90rpx;"></view>
					<view class="flex_1 fz30 c3 tac ">Comment details</view>
					<view style="width: 90rpx;" class="tac fz30 c3 iconguanbi"></view>
				</view>
				<view class="p30">
					<view class="allComment_top" v-if="childrenComment.id">
						<!--  -->
						<view class="list flex mb20 ">
							<view class="avt">
								<!-- <image :src="url + childrenComment.userpic" mode="" class="avt_img"></image> -->
								<img-cache :customStyle="customStyleAvt1" :src="url + childrenComment.userpic"
									width="72rpx" height="72rpx" mode="aspectFill"
									bgSrc="../../static/images/loading1.png"></img-cache>
							</view>
							<view class="flex_1">
								<!--  -->
								<view class="flex itc">
									<view class="flex_1 mr20">
										<view class="fz28 c3 oh1 ">{{childrenComment.username}}</view>
										<view class="fz22 c9 mb20">{{childrenComment.addtime}}</view>
									</view>
									<view class="reply fz26 ca mb10" @click.stop="topComment({id:childrenComment.id})">
										reply</view>
								</view>
								<!--  -->
								<view class="fz30 c3 mb10">{{childrenComment.replycontent}}</view>
								<view class="fz24 c9 flex itc mb20">
									<view class="icondianzan fz40 c9" :class="{'ca': childrenComment.islike == 1}"
										@click.stop="topGive({id:childrenComment.id,index:lookCommentChild.index},'top')">
									</view>
									<view class="fz20 c9 ml10"
										@click.stop="topGive({id:childrenComment.id,index:lookCommentChild.index},'top')">
										{{childrenComment.likenum}}
									</view>
								</view>
							</view>
						</view>
						<!--  -->
						<view class="flex itc">
							<view class="flex_1" style="height: 2rpx;background-color: #f4f4f4;"></view>
							<view class="fz30 c3 pl20 pr20">All replies</view>
							<view class="flex_1" style="height: 2rpx;background-color: #f4f4f4;"></view>
						</view>
						<!-- 所有二级评论 -->
						<view v-if="lookCommentChild && lookCommentChild.op">
							<view class="list flex mb20 "
								v-for="(item,index) in info.comment[lookCommentChild.index].commentlist_child">
								<view class="avt">
									<!-- <image :src="url + item.replypic" mode="" class="avt_img"></image> -->
									<img-cache :customStyle="customStyleAvt1" :src="url + item.userpic" width="72rpx"
										height="72rpx" mode="aspectFill" bgSrc="../../static/images/loading1.png">
									</img-cache>
								</view>
								<view class="flex_1">
									<!--  -->
									<view class="flex itc">
										<view class="flex_1 mr20">
											<view class="fz28 c3 oh1 ">{{item.username}}</view>
											<view class="fz22 c9 mb20">{{item.addtime}}</view>
										</view>
										<!-- <view class="reply fz26 ca mb10" @click="operation('comment',index,item)">reply</view> -->
									</view>
									<!--  -->
									<view class="fz30 c3 mb10">{{item.replycontent}}</view>
									<view class="fz24 c9 flex itc mb20">
										<view class="icondianzan fz40 c9" :class="{'ca': item.islike == 1}"
											@click.stop="topGive({id:item.id,index:index},'child')"></view>
										<view class="fz20 c9 ml10"
											@click.stop="topGive({id:item.id,index:index},'child')">{{item.likenum}}
										</view>
									</view>
								</view>
							</view>
						</view>
					</view>
				</view>

			</scroll-view>
		</view>
	</view>
</template>

<script>
	import commentList from '@/components/comment/index.vue';
	export default {
		data() {
			return {
				show: false,
				param: {},
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				info: {},
				desc: "",
				commentChildrenData: {}, //点击二级评论保存数据
				offSetTop: 0, //评论层距离顶部高度
				lookCommentChild: {}, //查看所有二级评论保存数据
				childrenComment: {}, //一级评论信息
				showCommentDetails: false, //显示评论详情标志 
				customStyleAvt1: {
					borderRadius: "50%"
				},
				showConfirm: true,
				pageTitle: ""
			}
		},
		onLoad(option) {
			this.param = option;
			// 显示qa打赏按钮
			this.showConfirm = Boolean(option.showQaBtn);
			this.offSetTop = uni.getSystemInfoSync().statusBarHeight + 44;
			this.getList();
			if (option.fromType == 'qa') {
				// uni.setNavigationBarTitle({
				// 	title: "Q&A"
				// })
				this.pageTitle = "Q&A";
				// if(this.param.className) {
				// 	this.pageTitle = "Q&A" + '-' +this.param.className
				// }
			} else if (option.fromType == 'bbs') {
				// uni.setNavigationBarTitle({
				// 	title: "Community"
				// })
				this.pageTitle = "Community"
				// if(this.param.className) {
				// 	this.pageTitle = "Community" + '-' +this.param.className
				// }
			} else if (option.fromType == 'discover') {
				// uni.setNavigationBarTitle({
				// 	title: "Discover"
				// })
				this.pageTitle = "Discover"
				
				// if(this.param.className) {
				// 	this.pageTitle = "Discover" + '-' +this.param.className
				// }
			}
			// console.log(this.userInfo)

		},
		components: {
			commentList
		},
		methods: {
			// 删除文章
			delInfo(_id) {
				uni.showModal({
					title: 'Tips',
					content: 'Are you sure you want to delete?',
					confirmText: "Sure",
					cancelText: "cancel",
					success: (res) => {
						if (res.confirm) {
							var datas = {
								apipage: this.param.fromType,
								op: "del",
								id: _id,
								tokenstr: this.token
							};
							this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
								if (res.error == 0) {
									this.requestSet.showToast('Success');
									setTimeout(() => {
										uni.navigateBack({
											delta: 1
										})
									}, 1000)
								} else {
									this.requestSet.showToast(res.returnstr);
								};
							}).catch((err) => {
								console.log(err)
							});
						}
					}
				});
			},
			// 获取分类名称
			getClassName(id) {
				console.log(id)
				var _list = this.qaClassList;
				console.log(_list)
				for (var i = 0; i < _list.length; i++) {
					if (_list[i].id == id) {
						return _list[i].name;
					}
				}
			},
			// 打开评论层
			showCom() {
				if (this.info.data.taskstatus == 1) {
					this.requestSet.showToast("It's done and can't be answered");
					return;
				}
				this.show = true;
			},
			//关注方法
			followFn() {
				var datas = {
					apipage: "userfollow",
					op: "follow",
					followid: this.info.data.userid,
					tokenstr: this.token
				};
				this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
					if (res.error == 0) {
						if (this.info.data.isfollow == 0) {
							this.info.data.isfollow = 1;
						} else {
							this.info.data.isfollow = 0;
						}
					} else {
						this.requestSet.showToast(res.returnstr);
					};
				}).catch((err) => {
					console.log(err)
				});
			},
			// 评论详情页的点赞
			topGive(e, op) {
				this.give(e, op);
			},
			// 评论详情页的顶部评论按钮
			topComment(e) {
				if (this.info.data.taskstatus == 1) {
					this.requestSet.showToast("It's done and can't be answered");
					return;
				}
				this.commentChildrenData = e;
				this.show = true;
			},
			/*
				评论中的操作
				1.give = 点赞
				2.comment = 评论
				3.look = 查看所有二级评论
			*/
			commentOperation(e) {
				switch (e.op) {
					case 'give':
						this.give(e);
						break;
					case 'comment':
						if (this.info.data.taskstatus == 1) {
							this.requestSet.showToast("It's done and can't be answered");
							return;
						}
						this.commentChildrenData = e;
						this.show = true;
						break;
					case 'look':
						this.childrenComment = this.info.comment[e.index].commentlist;
						this.lookCommentChild = e;
						this.showCommentDetails = true;
						console.log('查看全部')
						break;
				}
			},
			// 提交评论
			submit() {
				if (!this.token) {
					uni.navigateTo({
						url: "/pages/login/login"
					});
					return;
				};
				if (!this.desc) {
					this.requestSet.showToast('Please enter comments');
					return;
				};
				uni.showLoading({
					mask: true,
					title: "Loading"
				});
				var datas = {};
				if (this.param.fromType == 'discover') {
					datas = {
						apipage: "discover",
						id: this.param.id,
						tokenstr: this.token,
						op: "addcomment",
						parentid: "",
						description: this.desc
					};
				} else if (this.param.fromType == 'bbs') {
					datas = {
						apipage: "bbs",
						id: this.param.id,
						tokenstr: this.token,
						op: "addcomment",
						parentid: "",
						description: this.desc
					};
				} else if (this.param.fromType == 'qa') {
					datas = {
						apipage: "qa",
						id: this.param.id,
						tokenstr: this.token,
						op: "addcomment",
						parentid: "",
						description: this.desc
					};
				};
				if (this.commentChildrenData.id) {
					//列表数据
					var e = this.commentChildrenData;
					datas.id = this.param.id;
					datas.parentid = e.id;
				}
				this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
					if (res.error == 0) {
						this.desc = '';
						this.commentChildrenData = {};
						this.show = false;
						this.showCommentDetails = false;
						this.getList();

					} else {
						this.requestSet.showToast(res.returnstr);
					};

				}).catch((err) => {
					console.log(err)
				});
			},
			//点赞
			give(e, op) {
				console.log(this.param)
				/*
					e---来自二级页和评论详情页面
					
					
					op--评论详情页面
					 op = top  顶部一级评论点赞
					 op = child  二级评论点赞
				*/
				if (!this.token) {
					uni.navigateTo({
						url: "/pages/login/login"
					});
					return;
				};
				var datas = {};
				if (this.param.fromType == 'discover') {
					datas = {
						apipage: "discover",
						id: this.param.id,
						tokenstr: this.token,
						op: "collect",
						type: 2
					};
				} else if (this.param.fromType == 'bbs') {
					datas = {
						apipage: "bbs",
						id: this.param.id,
						tokenstr: this.token,
						op: "collect",
						type: 2
					};
				} else if (this.param.fromType == 'qa') {
					datas = {
						apipage: "qa",
						id: this.param.id,
						tokenstr: this.token,
						op: "collect",
						type: 2
					};
				};
				if (e.id) {
					// 评论数据
					datas.type = 3;
					datas.id = e.id;
				};
				this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
					if (res.error == 0) {
						if (e.id) {
							// console.log(this.info.comment[e.index].commentlist)
							if (op == 'child') {
								console.log('二级点赞')
								// 二级点赞处理
								this.info.comment[this.lookCommentChild.index].commentlist_child[e.index].islike =
									1;
								this.info.comment[this.lookCommentChild.index].commentlist_child[e.index]
									.likenum++;
							} else {
								console.log('一级点赞')
								this.info.comment[e.index].commentlist.islike = 1;
								this.info.comment[e.index].commentlist.likenum++;
							}

						} else {
							console.log('一级点赞');
							this.info.data.likenum++;
							this.info.data.islike = 1;
						}
					} else {
						this.requestSet.showToast(res.returnstr);
					};
				}).catch((err) => {
					console.log(err)
				});
			},

			//收藏
			collection() {
				if (!this.token) {
					uni.navigateTo({
						url: "/pages/login/login"
					});
					return;
				};
				var datas = {};
				if (this.param.fromType == 'discover') {
					datas = {
						apipage: "discover",
						id: this.param.id,
						tokenstr: this.token,
						op: "collect",
						type: 1
					};
				} else if (this.param.fromType == 'bbs') {
					datas = {
						apipage: "bbs",
						id: this.param.id,
						tokenstr: this.token,
						op: "collect",
						type: 1
					};
				} else if (this.param.fromType == 'qa') {
					datas = {
						apipage: "qa",
						id: this.param.id,
						tokenstr: this.token,
						op: "collect",
						type: 1
					};
				}
				this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
					if (res.error == 0) {
						if (this.info.data.iscollect == 1) {
							this.info.data.iscollect = 0;
						} else {
							this.info.data.iscollect = 1;
						}
					} else {
						this.requestSet.showToast(res.returnstr);
					};
				}).catch((err) => {
					console.log(err)
				});
			},
			// 切割图片路径
			getPic(item) {
				if (item) {
					return item.split('^')
				} else {
					return [];
				};
			},
			//标签切割
			tags(str) {
				if (str) {
					return str.split(',');
				} else {
					return [];
				}
			},
			getList() {
				var datas,_url;
				// console.log(this.param)
				if (this.param.fromType == 'discover') {
					datas = {
						discover_article_id: this.param.id,
					};
					_url = '/V1.DiscoverArticle/view';
				} else if (this.param.fromType == 'bbs') {
					datas = {
						community_article_id: this.param.id,
					};
					_url = '/V1.CommunityArticle/view';
				} else if (this.param.fromType == 'qa') {
					datas = {
						question_id: this.param.id,
					};
					_url = '/V1.Question/view';
				};
				this.requestSet.getData(datas, _url, 'GET').then((res) => {
					if (res.status == 200) {
						this.info = res.data;
					} else {
						this.requestSet.showToast(res.msg);
					}
					setTimeout(() => {
						this.isMark = false;
					}, 500)
				}).catch((err) => {
					console.log(err)
					this.isMark = true;
					this.markType = 2;
				});
			},
			refresh(data) { //刷新当前页数据
				if (data == this.timestamp) {
					this.getList();
				}
			},
		}
	}
</script>

<style>
	/* 关注模板 */
	.avt {
		width: 70rpx;
		height: 70rpx;
		border-radius: 50%;
		overflow: hidden;
	}

	.follow_btn {
		width: 135rpx;
		height: 50rpx;
		border-radius: 25rpx;
		background-color: #dfdfdf;
	}

	.btn_bg {
		background: linear-gradient(to right, #48cfb0, #48d39d);
		/* background: -webkit-linear-gradient(top, #48cfb0 ,#48d39d ); */
	}

	.big_img {
		width: 218rpx;
		height: 218rpx;
		overflow: hidden;
		border-radius: 10rpx;
	}

	.ml40 {
		margin-left: 40rpx;
	}

	.level image {
		display: block;
	}

	.tag {
		margin-right: 26rpx;
		line-height: 34rpx;
		border-radius: 18rpx;
		border: 1rpx #48ceb5 solid;
		padding: 0 20rpx;
		overflow: hidden;
	}

	.h130 {
		height: 130rpx;
	}

	.footer_box {
		position: fixed;
		width: 100%;
		height: 100rpx;
		left: 0;
		bottom: 0;
		background: #fff;
		box-shadow: 1rpx 1rpx 12rpx #ddd;
		z-index: 10;
	}

	.inp {
		border-radius: 10rpx;
		background-color: #f6f7f9;
		text-indent: 30rpx;
		height: 70rpx;
		line-height: 70rpx;
	}

	.commentBox {
		position: fixed;
		z-index: 99999999;
		border-top-right-radius: 20rpx;
		border-top-left-radius: 20rpx;
		width: 100%;
		left: 0;
		bottom: 0;
		transform: translate3d(0, 100%, 0);
	}

	.sub_btn {
		width: 120rpx;
		height: 70rpx;
		line-height: 70rpx;
		border-radius: 10rpx;
		margin-bottom: 20rpx;
	}

	.showCommentBox {
		transform: translate3d(0, 0, 0);
	}

	.jifen {
		width: 36rpx;
		height: 35rpx;
		display: block;
	}

	.allComment_box {
		position: fixed;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		background: #fff;
		transform: translate3d(0, 100%, 0);
		z-index: 10071;
	}

	.allComment_box_active {
		transform: translate3d(0, 0, 0);
	}

	/* 评论列表 */
	.avt {
		width: 72rpx;
		height: 72rpx;
		margin-right: 15rpx;
	}

	.avt_img {
		width: 100%;
		height: 100%;
		display: block;
		border-radius: 50%;
		overflow: hidden;
	}

	.reply {
		border-radius: 19rpx;
		line-height: 32rpx;
		height: 36rpx;
		box-sizing: border-box;
		width: 90rpx;
		text-align: center;
		border: 1rpx solid #48ceb5;
	}

	.btn_box {
		width: 100rpx;
		height: 144rpx;
	}

	.btn_img {
		width: 73rpx;
		height: 51rpx;

	}
</style>
