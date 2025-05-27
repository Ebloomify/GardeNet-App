<template>
	<view>
		<view class="" v-if="commentDataList.length">
			<view class="comment" v-for="(item, index) in commentDataList" :key="item.id">
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
					<view class="flex itc" v-if="item.back_sum > 0" @click="toAllReply(item)">
						<view class="fz20 c6">View {{item.back_sum}} reply</view>
						<view class="iconfont icontriangle-right fz20 c6"></view>
					</view>
					<view class="fz20 c9" v-else>No Reply</view>
					<!-- <view class="reply-box">
						<view class="item" v-for="(item, index) in 3" :key="item.index">
							<view class="username">阿斯顿</view>
							<view class="text">今天天气不错</view>
						</view>
						<view class="all-reply" @tap="toAllReply">
							共10条回复
							<u-icon class="more" name="arrow-right" :size="26"></u-icon>
						</view>
					</view> -->

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
				
			methods
				1.childComment	回复评论
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
			}
		},
		methods: {
			// 跳转到全部回复
			toAllReply(item) {
				uni.navigateTo({
					url: '/pages/index/reply?item=' + JSON.stringify(item)
				});
			},
			// 回复评论
			childComment(item) {
				this.$emit('childComment', item);
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
</style>
