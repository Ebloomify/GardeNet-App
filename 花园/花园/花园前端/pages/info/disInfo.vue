<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<u-navbar title="Discover" :border-bottom="true">
			<view slot="right" class="fz36 c3 pr30" @click="collection">
				<view class="iconshoucang c9" :class="{'ca': info.is_collect == true}"></view>
			</view>
		</u-navbar>
		<view class="fz28 ca tac">{{info.cate_name}}</view>
		<!--  -->
		<view>
			
			<view class="p30">
				<view class="title fz38 c3">推荐开发者上传到uniCloud，uniCloud提供了免费CDN和更好的易用性，包括安全的cdn直传。</view>
				<view class="fz24 c9 mt10">{{$r.initTime(info.create_time *1000)}}</view>
				<view class="h30"></view>
				<!-- 视频 -->
				<view class="mb20" v-if="info.video">
					<video :src="$r.imgUrl + info.video" style="width: 100%;"></video>
				</view>
				<view class="u-content">
					<u-parse :html="info.content" :domain="$r.imgUrl" :lazy-load="true"
						loading-img="./static/images/loading1.png"></u-parse>
				</view>
				<!-- 底部输入框 -->
				<view class="footer">
					<view class="h100"></view>
					<view class="footer_box ">
						<view class="flex p0_30 itc h100">
							<view class="inp fz24 c9 flex_1 mr20" @click="show = true">Say something</view>
							<view class="icondianzan fz40 c9" :class="{'ca' : info.is_like}" @click="give">
							</view>
							<view class="fz20 c9 ml10" @click="give">{{info.like_sum}}</view>
						</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 评论列表 -->
		<view>
			<view class="fz34 fw9 c3 pl30">Reply to all</view>
			<commentList :commentDataList="commentDataList" @childComment="childComment"></commentList>
			<view class="tac fz24 c9 lh100" v-if="commentDataList.length">No More</view>
		</view>
		<!-- 评论层 -->
		<view style="height: 100rpx;"></view>
		<u-mask :show="show" @click="show = false" z-index="10073"></u-mask>
		<view class="commentBox bgf trans" :class="{'showCommentBox' :show }">
			<view class="commentTiele flex h100 itc bb1">
				<view class="flex_1"></view>
				<view class="fz40 c3 iconguanbi tac" style="width: 100rpx;" @click="show = false"></view>
			</view>
			<!--  -->
			<view class="p30">
				<textarea maxlength="-1"  value="" placeholder="Say something" class="fz26 c3" v-model="desc"></textarea>
			</view>
			<!--  -->
			<view class="flex p0_30">
				<view class="flex_1"></view>
				<view class="sub_btn tac fz26 cf tac bga" @click="submit()">submit</view>
			</view>
		</view>
	</view>
</template>

<script>
	import commentList from '@/components/comment/index.vue';
	export default {
		data() {
			return {
				show: false, // 评论输入框标志
				param: {},
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				info: {},
				desc: "",
				offSetTop: 0, //评论层距离顶部高度
				showCommentDetails: false, //显示评论详情标志 
				customStyleAvt1: {
					borderRadius: "50%"
				},
				showConfirm: true,
				commentDataList: [], // 评论数据
				childCommentData: {} // 被回复的评论内容
			}
		},
		onLoad(option) {
			this.param = option;
			this.offSetTop = uni.getSystemInfoSync().statusBarHeight + 44;
		},
		onShow() {
			console.log(1111111111);
			// this.getList();
		},
		components: {
			commentList
		},
		methods: {
			// 打开评论层
			showCom() {
				// if (this.info.data.taskstatus == 1) {
				// 	this.requestSet.showToast("It's done and can't be answered");
				// 	return;
				// }
				this.show = true;
			},
			childComment(item) {
				this.childCommentData = item;
				this.show = true;
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
				
				var datas = {
					discover_article_id: this.param.id,
					content: this.desc
				};
				if (this.childCommentData.discover_comment_id) {
					datas.pid = this.childCommentData.discover_comment_id;
				}
				uni.showLoading({
					mask: true,
					title: "Loading"
				});
				this.requestSet.getData(datas, '/V1.DiscoverComment/add', 'POST').then((res) => {
					if (res.status == 200) {
						this.childCommentData = {};
						this.desc = '';
						this.show = false;
						this.getList();
					} else {
						this.requestSet.showToast(res.msg);
					};

				}).catch((err) => {
					console.log(err)
				});
			},
			//点赞
			give() {
				// 类型 discover|1,community|2,qa|3,discover评论|4,community评论|5,qa评论|6
				if (!this.token) {
					uni.navigateTo({
						url: "/pages/login/login"
					});
					return;
				};
				var datas = {
					type: 1,
					object_id: this.param.id
				};
				this.requestSet.getData(datas, '/V1.MemberLike/addAndRemove', 'POST').then((res) => {
					if (res.status == 200) {
						if(res.msg == '点赞成功') {
							this.info.is_like = true;
							this.info.like_sum++;
						} else if(res.msg == '取消点赞成功'){
							this.info.is_like = false;
							this.info.like_sum--;
						};
						this.$r.showToast('Success');
					} else {
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					console.log(err)
				});
			},
			//收藏
			collection() {
				// 类型 discover|1,community|2,qa|3,discover评论|4,community评论|5,qa评论|6
				if (!this.token) {
					uni.navigateTo({
						url: "/pages/login/login"
					});
					return;
				};
				var datas = {
					type: 1,
					object_id: this.param.id
				};
				this.requestSet.getData(datas, '/V1.MemberCollect/addAndRemove', 'POST').then((res) => {
					if (res.status == 200) {
						if(res.msg == '收藏成功') {
							this.info.is_collect = true;
						} else if(res.msg == '取消收藏成功'){
							this.info.is_collect = false;
						};
						this.$r.showToast('Success');
					} else {
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					console.log(err)
				});
			},
			getList() {
				var datas, _url;
				// console.log(this.param)
				datas = {
					discover_article_id: this.param.id,
				};
				_url = '/V1.DiscoverArticle/view';
				this.requestSet.getData(datas, _url, 'GET').then((res) => {
					if (res.status == 200) {
						this.info = res.data;
						this.getCommentList();
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
			// 获取评论列表
			getCommentList() {
				var datas = {
					discover_article_id: this.param.id,
					page: 1,
					limit: 10000
				};
				this.requestSet.getData(datas, '/V1.DiscoverComment/index', 'GET').then((res) => {
					if (res.status == 200) {
						// this.commentDataList = this.commentDataList.concat(res.data.list);
						this.commentDataList = res.data.list;
					} else {
						this.requestSet.showToast(res.msg);
					}
					
				}).catch((err) => {
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
