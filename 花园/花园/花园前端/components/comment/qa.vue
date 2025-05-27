<template>
	<view>
		<view class="" v-if="commentDataList.length">
			<!-- <view class="">{{info.resolved_status}}</view>	 -->
			<view class="comment " v-for="(item, index) in commentDataList" :key="item.id">
				<view class="left">
					<image :src="$r.imgUrl + item.avatar" mode="aspectFill"></image>
				</view>
				<view class="right">
					<view class="top">
						<view class="name">
							<view class="mb5">{{ item.nickname }}</view>
							<view class="bottom">{{$r.initTime(item.create_time * 1000 , 'day')}}</view>
						</view>
						<view class="like" :class="{ highlight: item.is_like }">
							<view class="icondianzan fz40 c9" :class="{'ca' : item.is_like}"
								@click="getLike(index,item)"></view>
							<view class="num ml10">{{ item.like_sum }}</view>
						</view>
					</view>
					<view class="content mb20" @click="childComment(item)">{{ item.content }}</view>
					<view class="flex itc" v-if="item.reply_num > 0" @click="toAllReply(item)">
						<view class="fz20 c6">View {{item.reply_num}} reply</view>
						<view class="iconfont icontriangle-right fz20 c6"></view>
					</view>
					<view class="fz20 c9" v-else>No Reply</view>
				</view>
				<!--  -->
				<!-- <view class="btn_box boxSha ml20" v-if="userInfo.data && userInfo.data.member_id == info.member_id" @click="checkComment(item)"> -->
				<view class="btn_box boxSha ml20" @click="checkComment(item)"  v-if="getShow(item)">
					<view class="check_list">
						<image src="../../static/images/q_06.png" mode="widthFix" class="w100"></image>
						<view class="tac fz20" style="color: rgb(251, 205, 57);">Accept</view>
					</view>
				</view>
				<view class="btn_box boxSha ml20" @click="checkComment(item)"  v-if="item.is_accept == 1">
					<view class="accepted">
						<image src="../../static/images/q_03.png" mode="widthFix" class="w100"></image>
						<view class="tac fz20" style="color: rgb(251, 205, 57);">Accepted</view>
					</view>
				</view>
			</view>
		</view>
		<!--  -->
		<view v-else>
			<view class="h100"></view>
			<u-empty text="No Data" mode="list"></u-empty>
			<view class="h100"></view>
		</view>
	</view>
</template>

<script>
	export default {
		/*
			props
				1.commentList  评论数据
				2.info  文章详情
			methods
				1.childComment	回复评论
				2.refreshInfo刷新页面数据
		*/
		data() {
			return {
				// commentList: []
			};
		},
		props: {
			commentDataList: {
				type: Array,
				default: []
			},
			info: {
				type: Object,
				default: {}
			}
		},
		created() {
			console.log(this.userInfo);
			console.log(this.userInfo.data.member_id);
		},
		methods: {

			/*
				控制选择答案按钮
				
			*/ 
			getShow(item) {
				/*
					info.resolved_status=2 已完成
					item.is_accept == 1  已选中的评论
				*/
			   
			   if(this.info.resolved_status == 2) { // 已完成状态不显示选择按钮
				   return false;
			   } else {
				   if(this.userInfo) { // 已登录
					   var _userId = this.userInfo.data.member_id;
					   if(this.info.member_id == _userId) {
						   return true;
					   }
				   } 
			   }
			},
			// 选择评论
			checkComment(item) {
				// 自己选择自己的答案
				if (this.info.member_id == this.userInfo.data.member_id && this.userInfo.data.member_id == item.member_id) {
					this.requestSet.showToast("Can't choose your own answer");
					return;
				};
				// 不是当前人得文章
				if (this.info.member_id != this.userInfo.data.member_id) {
					return;
				};
				if (this.info.resolved_status == 2) {
					uni.showModal({
						title: 'Tips',
						content: 'Current issue completed',
						confirmText: "OK",
						showCancel: false
					});
					return;
				};
				uni.showModal({
					title: 'Tips',
					content: 'Are you sure to adopt this suggestion? It cannot be modified after selection',
					confirmText: "OK",
					cancelText: "Cancel",
					success: (res) => {
						if (res.confirm) {
							var datas = {
								question_answer_id: item.question_answer_id
							};
							uni.showLoading({
								title: 'Loading',
								mask: true,
							});
							this.requestSet.getData(datas, '/V1.QuestionAnswer/pitchOn', 'POST').then((
								res) => {
								if (res.status == 200) {
									this.$emit("refreshInfo")
								} else {
									this.requestSet.showToast(res.msg);
								};
							}).catch((err) => {

							});
						}
					}
				});
			},
			// 跳转到全部回复
			toAllReply(item) {
				uni.navigateTo({
					url: '/pages/qa/reply?item=' + JSON.stringify(item) + '&status=' + this.info
						.resolved_status
				});
				// if (this.info.resolved_status == 1) {
				// 	uni.navigateTo({
				// 		url: '/pages/qa/reply?item=' + JSON.stringify(item) + '&status=' + this.info
				// 			.resolved_status
				// 	});
				// }

			},
			// 回复评论
			childComment(item) {
				if (this.info.resolved_status == 1) {
					this.$emit('childComment', item);
				}
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
					type: 6,
					object_id: item.question_answer_id
				};
				this.requestSet.getData(datas, '/V1.MemberLike/addAndRemove', 'POST').then((res) => {
					if (res.status == 200) {
						this.commentDataList[index].is_like = !this.commentDataList[index].is_like;
						if (this.commentDataList[index].is_like == true) {
							this.commentDataList[index].like_sum++;
						} else {
							this.commentDataList[index].like_sum--;
						}
						this.$r.showToast('Success');
					} else {
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					console.log(err)
				});

			},
		}
	};
</script>

<style lang="scss" scoped>
	.comment {
		display: flex;
		padding: 30rpx;

		.left {
			image {
				width: 64rpx;
				height: 64rpx;
				border-radius: 50%;
				background-color: #f2f2f2;
			}
		}

		.right {
			flex: 1;
			padding-left: 20rpx;
			font-size: 30rpx;

			.top {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 10rpx;

				.name {
					color: #333;
				}

				.like {
					display: flex;
					align-items: center;
					color: #9a9a9a;
					font-size: 26rpx;

					.num {
						margin-right: 4rpx;
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

			.content {
				margin-bottom: 10rpx;
			}

			.reply-box {
				background-color: rgb(242, 242, 242);
				border-radius: 12rpx;

				.item {
					padding: 20rpx;
					border-bottom: solid 2rpx $u-border-color;

					.username {
						font-size: 24rpx;
						color: #999999;
					}
				}

				.all-reply {
					padding: 20rpx;
					display: flex;
					color: #5677fc;
					align-items: center;

					.more {
						margin-left: 6rpx;
					}
				}
			}

			.bottom {
				// margin-top: 20rpx;
				display: flex;
				font-size: 24rpx;
				color: #9a9a9a;

				.reply {
					color: #5677fc;
					margin-left: 10rpx;
				}
			}
		}
	}

	// 
	.btn_box {
		width: 100rpx;
		height: 144rpx;
		border-radius: 5rpx;
		overflow: hidden;
	}

	.btn_img {
		width: 73rpx;
		height: 51rpx;

	}

	.info {
		white-space: pre-wrap;
		white-space: -moz-pre-wrap;
		white-space: -pre-wrap;
		white-space: -o-pre-wrap;
		*word-wrap: break-word;
		*white-space: normal;
	}

	.check_list {
		width: 100rpx;
		height: 144rpx;
		background-color: #F3F4F6;
	}

	.check_list image,
	.accepted image {
		margin-top: 20rpx;
		height: auto;
	}

	.accepted {
		background: #fff;
	}

	.mohu {
		// color: transparent;
		// text-shadow: 0 0 10rpx grab(0,0,0,0.5);

		filter: blur(5px);
	}
</style>
