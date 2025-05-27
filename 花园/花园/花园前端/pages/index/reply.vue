<template>
	<view class="wrap">
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<view class="comment">
			<view class="top">
				<view class="left">
					<view class="heart-photo">
						<image :src="$r.imgUrl + param.avatar" mode=""></image>
					</view>
					<view class="user-info">
						<view class="name">{{ param.nickname }}</view>
						<view class="date">{{$r.initTime(param.create_time * 1000 , 'day')}}</view>
					</view>
				</view>
				<view class="like" :class="{ highlight: param.is_like }">
					<view class="flex">
						<view class="icondianzan fz40 c9" :class="{'ca' : param.is_like}" @click="topLike">
						</view>
						<view class="num ml10">{{ param.like_sum }}</view>
					</view>
				</view>
			</view>
			<view class="content mt20">{{ param.content }}</view>
		</view>
		<view class="all-reply">
			<view class="all-reply-top">Reply all（{{ totalNum }}）</view>
			<view class="item" v-for="(item, index) in commentDataList" :key="index">
				<view class="comment">
					<view class="top">
						<view class="left">
							<view class="heart-photo">
								<image :src="$r.imgUrl + item.avatar" mode=""></image>
							</view>
							<view class="user-info">
								<view class="name">{{ item.nickname }}</view>
								<view class="date">{{$r.initTime(item.create_time * 1000 , 'day')}}</view>
							</view>
						</view>
						<view class="right" :class="{ highlight: item.is_like }">
							<view class="flex itc">
								<view class="icondianzan fz40 c9" :class="{'ca' : item.is_like}"
									@click="getLike(index,item)">
								</view>
								<view class="num ml10">{{ item.like_sum }}</view>
							</view>
						</view>
					</view>
					<view class="reply" v-if="item.reply">
						<view class="username">{{ item.reply.name }}</view>
						<view class="text">{{ item.reply.contentStr }}</view>
					</view>
					<!-- <view class="content mt20" @click="childComment(item)">{{ item.content }}</view> -->
					<view class="content mt20">{{ item.content }}</view>
				</view>
			</view>
		</view>
		<!-- 底部输入框 -->
		<view class="footer  ">
			<view class="h100"></view>
			<view class="footer_box bt1 bgf">
				<view class="flex p0_30 itc h100">
					<view class="inp fz24 c9 flex_1 " @click="show = true">Say something</view>
				</view>
			</view>
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
				<textarea maxlength="-1" value="" placeholder="Say something" class="fz26 c3" v-model="desc"></textarea>
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
	export default {
		data() {
			return {
				param: {},
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				commentDataList: [],
				totalNum: 0,
				show: false, // 评论输入框标志
				desc: "",
				childCommentData: {}
			};
		},
		onLoad(option) {
			this.param = JSON.parse(option.item);
			this.getList();
		},
		methods: {
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
					discover_article_id: this.param.discover_article_id,
					content: this.desc,
					pid: ""
				};
				if (this.childCommentData.discover_comment_id) {
					datas.pid = this.childCommentData.discover_comment_id;
				} else {
					datas.pid = this.param.discover_comment_id;
				};
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
			topLike() {
				// 类型 discover|1,community|2,qa|3,discover评论|4,community评论|5,qa评论|6
				if (!this.token) {
					uni.navigateTo({
						url: "/pages/login/login"
					});
					return;
				};
				var datas = {
					type: 4,
					object_id: this.param.discover_comment_id
				};
				this.requestSet.getData(datas, '/V1.MemberLike/addAndRemove', 'POST').then((res) => {
					if (res.status == 200) {
						this.param.is_like = !this.param.is_like;
						if (this.param.is_like == true) {
							this.param.like_sum++;
						} else {
							this.param.like_sum--;
						}
						this.$r.showToast('Success');
					} else {
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					console.log(err)
				});
			},
			// 点赞
			getLike(index, item) {
				// 类型 discover|1,community|2,qa|3,discover评论|4,community评论|5,qa评论|6
				if (!this.token) {
					uni.navigateTo({
						url: "/pages/login/login"
					});
					return;
				};
				var datas = {
					type: 4,
					object_id: item.discover_comment_id
				};
				this.requestSet.getData(datas, '/V1.MemberLike/addAndRemove', 'POST').then((res) => {
					if (res.status == 200) {
						item.is_like = !item.is_like;
						if (item.is_like == true) {
							item.like_sum++;
						} else {
							item.like_sum--;
						}
						this.$r.showToast('Success');
					} else {
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					console.log(err)
				});
			},
			// 获取评论列表
			getList() {
				var datas = {
					discover_article_id: this.param.discover_article_id,
					pid: this.param.discover_comment_id,
					page: 1,
					limit: 10000
				};
				this.requestSet.getData(datas, '/V1.DiscoverComment/index', 'GET').then((res) => {
					if (res.status == 200) {
						// this.commentDataList = this.commentDataList.concat(res.data.list);
						this.commentDataList = res.data.list;
						this.totalNum = res.data.count;
					} else {
						this.requestSet.showToast(res.msg);
					}
					setTimeout(() => {
						this.isMark = false;
					}, 500)
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
	};
</script>

<style lang="scss" scoped>
	page {
		background-color: #f2f2f2;
	}

	.comment {
		padding: 30rpx;
		font-size: 32rpx;
		background-color: #ffffff;

		.top {
			display: flex;
			justify-content: space-between;
		}

		.left {
			display: flex;

			.heart-photo {
				image {
					width: 64rpx;
					height: 64rpx;
					border-radius: 50%;
					background-color: #f2f2f2;
				}
			}

			.user-info {
				margin-left: 10rpx;

				.name {
					color: #5677fc;
					font-size: 28rpx;
					margin-bottom: 4rpx;
				}

				.date {
					font-size: 20rpx;
					color: $u-light-color;
				}
			}
		}

		.right {
			display: flex;
			font-size: 20rpx;
			align-items: center;
			color: #9a9a9a;

			.like {
				margin-left: 6rpx;
			}

			.num {
				font-size: 26rpx;
				color: #9a9a9a;
			}
		}

		.highlight {
			color: #5677fc;

			.num {
				color: #5677fc;
			}
		}
	}

	.all-reply {
		margin-top: 10rpx;
		padding-top: 20rpx;
		background-color: #ffffff;

		.all-reply-top {
			margin-left: 20rpx;
			padding-left: 20rpx;
			border-left: solid 4rpx #5677fc;
			font-size: 30rpx;
			font-weight: bold;
		}

		.item {
			border-bottom: solid 2rpx $u-border-color;
		}

		.reply {
			padding: 20rpx;
			background-color: rgb(242, 242, 242);
			border-radius: 12rpx;
			margin: 10rpx 0;

			.username {
				font-size: 24rpx;
				color: #7a7a7a;
			}
		}
	}

	.num {
		margin-right: 4rpx;
		color: #9a9a9a;
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
</style>
