<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<view class="top_box" id="box" v-if="info && info.nickname">
			<view style="height: 320rpx; position: relative;">
				<view class="avt">
					<image :src="url + info.avatar" mode=""></image>
				</view>
			</view>
			<!--  -->
			<view class="p30">
				<view class="fz40 c3 fw9 oh1">{{info.nickname}}</view>
				<view class="fz28 c9 oh1">{{info.human_desc}}</view>
				<view class="flex itc mt20 mb40">
					<image :src="`../../static/images/l${info.member_level}.png`" mode="widthFix" :class="'l'+info.member_level"></image>
				</view>
				<view class="flex itc">
					<view class="tac">
						<view class="fz34 c3">{{info.follows}}</view>
						<view class="fz26 c9">Follow</view>
					</view>
					<view style="width: 80rpx;"></view>
					<view class="tac mr20">
						<view class="fz34 c3">{{info.fans}}</view>
						<view class="fz26 c9">Fans</view>
					</view>
					<view class="flex_1"></view>
					<view class="">
						<!-- 关注 -->
						<!-- <view class="follow_btn flex itc juc btn_bg">
							<view class="iconjia cf fz18 mr5"></view>
							<view class="fz28 cf">follow</view>
						</view> -->
						<view class="follow_btn flex itc juc " :class="{'btn_bg' : info.is_follow == 1}" @click.stop="followFn(info)">
							<view class="iconjia cf fz18 mr5" v-if="info.is_follow == 0"></view>
							<view class="fz28 cf">{{info.is_follow == 0 ? 'follow' : 'following'}}</view>
						</view>
					</view>
				</view>
			</view>
			<view class="h10 bgf4"></view>
		</view>
		<!-- 滚动内容区域 -->
		<view :style="{height: `calc(${windowHeight}px - 44px - ${statusBarHeight}px)`}" class="scrollHook" v-if="info && info.member_permission_status == 1">
			<!-- tab标题 -->
			<view class="box oh">
				<view class="">
					<u-tabs ref="tabs" :is-scroll="false" :bar-style="barStyle" gutter="30" @change="tabChange" :list="tabs"
					 active-color="#333" inactive-color="#666" font-size="30" :current="current"></u-tabs>
				</view>
				<view style="height: 1rpx;background-color: #f4f4f4;"></view>
			</view>
			<!-- 滚动内容 -->
			<view class="swiper_box" :style="{height: `calc(${windowHeight}px - 44px - 80rpx - ${statusBarHeight}px)`}">
				<!--  -->
				<swiper style="height: 100%" :current="current" @change="swiperChange" :duration="500">
					<!--全部 -->
					<swiper-item v-for="(item,index) in tabs">
						<MescrollItems :i="index" :index="current" :tabs="tabs" :isSroll="isSroll" :userId="param.id" :infoData="info"></MescrollItems>
					</swiper-item>
					<!--  -->
				</swiper>
			</view>
		</view>
		<!--  -->
		<view v-else>
			<view class="h100"></view>
			<u-empty text="User settings not viewable" mode="permission"></u-empty>
		</view>
	</view>
</template>

<script>
	import MescrollItems from "./mescroll-swiper-item.vue";
	export default {
		components: {
			MescrollItems,
		},
		data() {
			return {
				param: {},
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				info: {}, //详细数据
				windowHeight: 0, //页面高度
				statusBarHeight: 0, //状态栏高度
				isSroll: false, // 列表区域是否能滚动
				topHeight: 0, //滚动区域以上高度，用来计算当前页面是否能滚动
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
					name: "Communitv Post",
					ajaxUrl: "",
					template: 'BSS'
				}, {
					name: "Q & A",
					ajaxUrl: "",
					template: 'QA'
				}, {
					name: "Garden",
					ajaxUrl: "",
					template: 'garden'
				}]
			}
		},
		onLoad(option) {
			this.param = option;

			this.getList();
		},
		onPageScroll(e) {
			// console.log(e.scrollTop +'---'+(this.topHeight - 45))
			if (e.scrollTop >= this.topHeight - 45 - this.statusBarHeight) {
				this.isSroll = true;
			} else {
				this.isSroll = false;
			}
		},
		methods: {
			//关注方法
			followFn(item) {
				if (!this.token) {
					uni.navigateTo({
						url: "/pages/login/login"
					});
					return;
				};
				var datas = {
					follow_member_id: item.member_id
				};
				this.requestSet.getData(datas, '/V1.MemberFollow/addAndRemove', 'POST').then((res) => {
					if (res.status == 200) {
						if (res.msg == '关注成功') {
							item.is_follow = 1;
						} else if (res.msg == '取消关注成功') {
							item.is_follow = 0;
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
				var datas = {
					member_id: this.param.id,
				};
				this.requestSet.getData(datas, '/V1.Member/info', 'GET').then((res) => {
					if (res.status == 200) {
						this.info = res.data;
					} else {
						this.requestSet.showToast(res.msg);
					};
					setTimeout(() => {
						this.initHeight();
					}, 200)
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
			// 计算滚动区域高度
			initHeight() {
				this.sys = uni.getSystemInfoSync();
				this.windowHeight = this.sys.windowHeight;
				this.statusBarHeight = this.sys.statusBarHeight;
				// 计算 内容区域高度
				const query = uni.createSelectorQuery().in(this);
				query.select('#box').boundingClientRect(data => {
					if (!data) {
						setTimeout(() => {
							this.initHeight();
						}, 200)
					} else {
						this.topHeight = data.height;
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
			}
		}
	}
</script>

<style>
	.top_box {
		background: url(../../static/images/indexbg.jpg) no-repeat top left;
		background-size: 100% auto;
	}

	.avt {
		width: 156rpx;
		height: 156rpx;
		border: 4rpx solid #fff;
		border-radius: 50%;
		overflow: hidden;
		position: absolute;
		right: 30rpx;
		bottom: -80rpx;
	}

	.avt image {
		width: 100%;
		height: 100%;
		display: block;
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

	.scrollHook {
		position: relative;
	}
</style>
