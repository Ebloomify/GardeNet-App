<template>
	<view>
		<view class="box" id="box">
			<view class="p0_30">
				<view class="top_warpper bor20 boxSha oh bgf mb10">
					<view class="p0_30">
						<view class="h20"></view>
						<view class="top_box flex itc">
							<view class="mr40">
								<image :src="$r.imgUrl + userInfo.data.avatar" mode="" class="avt"></image>
							</view>
							<view class="flex_1 mr40">
								<view class="fz40 c3 oh1 mb20">{{userInfo.data.nickname}}</view>
								<view class="flex itc" @click="nav('/pages/center/integral/integral')">
									<image :src="`../../../static/images/l${userInfo.data.member_level}.png`"
										mode="widthFix" :class="'l'+userInfo.data.member_level"></image>
								</view>
								<view class="flex itc">
									<view class="mr20" style="width: 280rpx;">
										<u-line-progress active-color="#59d2b6" :percent="getPercentage()" height="4"
											:show-percent="false"></u-line-progress>
									</view>
									<view class="fz20 c9">{{integralData.member_level.member_level_exp}}/{{getMax()}}
									</view>
								</view>
							</view>
						</view>
						<!--  -->
						<view class="flex itc mt10">
							<view class="flex_1">
								<view class="fz26 c6">Total Rewards：<text
										class="ca">{{integralData.member_level.all_integral}}</text></view>
							</view>
							<view class="flex_1 tar">
								<view class="fz26 c6">Available Rewards：<text
										class="ca">{{integralData.member_level.integral}}</text></view>
							</view>
						</view>
					</view>
				</view>
			</view>
			<!--  -->
			<u-tabs ref="tabs" :show-bar="showBar" :bar-style="barStyle" gutter="30" @change="tabChange" :list="tabs"
				active-color="#333" inactive-color="#666" font-size="30" :current="current"></u-tabs>
			<view class="h10 bgf4"></view>
		</view>
		<!-- swiper -->
		<view class="" :style="{height: parentHeight}">
			<swiper class="h100" :indicator-dots="false" :autoplay="false" :duration="500" :current="current"
				@change="swiperChange">
				<swiper-item>
					<scroll-view scroll-y="true" class="h100">
						<view class="swiper-item p30">

							<view class="flex itc mb20" v-for="(item,index) in integralData.config_member_integer">
								<image :src="`../../../static/images/l${index+1}.png`" mode="" class="mr20 l1"></image>
								<view class="fz22 c9">{{item.content}}</view>
							</view>

						</view>

					</scroll-view>

				</swiper-item>
				<swiper-item>
					<scroll-view scroll-y="true" style="height: 100%;" @scrolltolower="scrolltolower">
						<view class="swiper-item">
							<view class="flex itc" v-for="item in list">
								<view class=" mr20">
									<view class="fz26 c6 tac" style="width: 200rpx;">
										{{$r.initTime(item.create_time * 1000)}}
									</view>
								</view>
								<view class="flex_1 bb1" style="height: 100rpx;">
									<view class="flex h100 itc">
										<view class="fz26 c3 flex_1 mr20">{{item.inte_desc}}</view>
										<view class="fz26 ca mr20">{{item.type == "1" ? "+" : "-"}}{{item.integral}}
										</view>
									</view>
								</view>
							</view>
							<view class="fz24 c9 tac lh100">{{isMore? 'Loading' : 'No More'}}</view>

						</view>

					</scroll-view>
				</swiper-item>
				<!--  -->
				<swiper-item>
					<scroll-view scroll-y="true" style="height: 100%;">
						<view class="swiper-item">
							<!-- 积分任务 -->
							<view class="p30" style="border-bottom: 4rpx solid #f6f7f9;">
								<!-- 1 -->
								<view class=" c3 fz24 lh40 mb30">
									The following list shows the operations and how many points can be earned through
									the operation each time. The following numbers mean the finished operation number /
									the total available operation number in one day. For example, “Post in Community +6
									points 1/5” means in Community, you post one article you can earn 6 points, but you
									only allow to post 5 articles in one day. So far you already post one article.
								</view>
								<view class="flex itc mb30" v-for="item in integralData.config_integer">
									<view class="flex_1 mr20">
										<view class="fz32 c3">{{item.name}}</view>
										<view class="fz28 ca">+{{item.add_integer}}points</view>
									</view>
									<view class="ibtn fz28 cf tac boxSha">{{item.member_finish_num}}/{{item.finish_sum}}
									</view>
									<!-- <view class="ibtn fz28 cf tac boxSha" v-else></view> -->
								</view>
								<!--  -->
								
							</view>
							<!-- 积分说明 -->
							<view class="p30">
								<view class="line_title fz34 c3">Florescence:</view>
								<view class="h30"></view>
								<view class="pl50 fz30 c6 lh50">
									How to get points
									Community posts
									Be rewarded by answering questions (we used to reward directly with money, now use
									points instead)
									Invite friends
								</view>
							</view>
						</view>
					</scroll-view>
				</swiper-item>
			</swiper>
		</view>
	</view>
</template>

<script>
	// 任务列表
	var taskList = [{
			name: "Post in Community",
			totalNum: 5,
			integral: 5
		}, {
			name: "Comment the post",
			totalNum: 10,
			integral: 2
		}, {
			name: "Like the post",
			totalNum: 5,
			integral: 2
		}, {
			name: "Invite friends",
			totalNum: 10,
			integral: 200
		}, {
			name: "Sign in",
			totalNum: 1,
			integral: 10
		}, {
			name: "Look at advertisements",
			totalNum: 1,
			integral: 10,
			type: "AD"
		},
		// 以下任务不计次数
		{
			name: "Post is highlighted",
			totalNum: -1,
			integral: 50
		}, {
			name: "My garden is public",
			totalNum: -1,
			integral: 200
		}, {
			name: "Each Purchase",
			totalNum: -1,
			integral: 5
		}
	]
	export default {
		data() {
			return {
				param: {},
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				sys: "",
				parentHeight: {},
				current: 0, //tab 索引
				barStyle: {
					background: "linear-gradient(to right, #48d39a, #48ceb7)",
					// bottom: "18rpx",
					height: "8rpx"
				},
				showBar: true,
				tabs: [{
					name: "Hierarchy rules"
				}, {
					name: "Reward Activties"
				}, {
					name: "Earn points"
				}],
				pageIndex: 1,
				list: [],
				integralData: {
					member_level: {
						member_level_exp: 0,
						all_integral: 0,
						integral: 0
					}
				},
				isMore: false,
				isLoad: false
			}
		},
		onLoad() {
			// var jygooglead = uni.requireNativePlugin("JY-GoogleAdMob");
			// jygooglead.jy_init();
		},
		onReady() {
			this.initHeight();
			this.getList();
		},
		methods: {
			jy_showRewardedAd() {
				uni.hideLoading();
				var jygooglead = uni.requireNativePlugin("JY-GoogleAdMob");
				jygooglead.jy_showRewardedAd({},
					res => {
						console.log(JSON.stringify(res));
						uni.showToast({
							icon: 'none',
							title: JSON.stringify(res)
						})
					})
			},
			jy_loadRewardedAd() {
				uni.showLoading({
					mask: true,
					title: "Loading"
				})
				var jygooglead = uni.requireNativePlugin("JY-GoogleAdMob");
				jygooglead.jy_loadRewardedAd({
					adId: "ca-app-pub-3940256099942544/5224354917",
					appId: "ca-app-pub-2903707703741332~4643865204"
				}, res => {
					console.log(res);
					if (!this.isVideo) {
						this.jy_showRewardedAd();
					};
					if (res.errorCode == 0 && res.code == 103) {
						this.isVideo = false;
					} else {
						this.isVideo = true;
					}
					if (res.errorCode == 0 && res.data && res.data.code == '104') {
						uni.showModal({
							title: 'Tips',
							content: 'Award received',
							confirmText: "Sure",
							showCancel: false,
							success: (res) => {
								if (res.confirm) {

								}
							}
						});
					}

				})
			},
			/*
				初始化积分信息
				返回
					1.积分等级
					2.当前等级升级上线经验数值
					3.当前经验百分比
			*/
			// scroll-view 滚动加载
			scrolltolower() {
				//不在加载中 并且 还有更多数据
				if (!this.isLoad && this.isMore) {
					this.getList();
				}
			},
			getIntegral(item) {
				if (item.type == 'AD') {
					this.jy_loadRewardedAd()
				}
			},
			// 获取升级最大值
			getMax() {
				if (this.integralData.member_level.member_level) {
					var _level = this.integralData.member_level.member_level;
					return this.integralData.config_member_integer[_level - 1].max;
				}
			},
			// 获取级别进度条百分比
			getPercentage() {
				return this.integralData.member_level.member_level_exp / this.getMax() * 100;
			},
			getList() {
				var datas = {
					limit: this.$r.pageSize,
					page: this.pageIndex
				};
				this.requestSet.getData(datas, '/V1.MemberIntegral/index', 'GET').then((res) => {
					if (res.status == 200) {
						this.integralData = res.data;
						if (this.pageIndex == 1) {
							this.list = res.data.member_integer.list;
						} else {
							this.list = this.list.concat(res.data.member_integer.list);
						};
						this.getNextPage(res.data.member_integer.list);
					} else {
						this.requestSet.showToast(res.msg);
					};
					this.isMark = false;
				}).catch((err) => {
					console.log(err)
					this.isMark = true;
					this.markType = 2;
				});
			},
			initHeight() {
				this.sys = uni.getSystemInfoSync();
				this.windowHeight = this.sys.windowHeight;
				this.statusBarHeight = this.sys.statusBarHeight;

				// 计算 内容区域高度
				// ----------------	
				const query = uni.createSelectorQuery().in(this);
				query.select('#box').boundingClientRect(data => {
					// console.log(data);
					if (!data) {
						setTimeout(() => {
							this.initHeight();
						}, 200)
					} else {
						console.log(data);
						this.parentHeight =
							`calc(${this.windowHeight}px - ${this.statusBarHeight}px - ${data.height}px)`;
					}
				}).exec();
			},
			//tab改变事件
			tabChange(e) {
				this.current = e;
			},
			// 轮播菜单
			swiperChange(e) {
				this.current = e.detail.current
			},
			//判断是否还有更多数据
			getNextPage(list) {
				//列表长度 等于 分页数量长度
				if (list.length == this.$r.pageSize) {
					this.pageIndex++;
					this.isMore = true;
				} else {
					this.isMore = false;
				};
			}
		}
	}
</script>

<style>
	page {
		height: calc(100vh - var(--window-top));
		overflow: hidden;
	}

	.box {
		background: url(../../../static/images/jfbg.jpg);
		background-size: 100% auto;
		background-repeat: no-repeat;
		background-position: top left;
	}

	.top_warpper {
		height: 228rpx;
	}

	.avt {
		width: 122rpx;
		height: 122rpx;
		display: block;
		border-radius: 50%;
	}

	.mr40 {
		margin-right: 40rpx;
	}

	.h100 {
		height: 100%;
	}

	.ibtn {
		width: 134rpx;
		height: 50rpx;
		line-height: 50rpx;
		border-radius: 25rpx;
		background: linear-gradient(to right, #48cfb0, #48d39d);
	}

	.line_title {
		line-height: 34rpx;
		height: 34rpx;
		border-left: 6rpx solid #5fcfa0;
		text-indent: 30rpx;
	}

	.pl50 {
		padding-left: 50rpx;
	}
</style>
