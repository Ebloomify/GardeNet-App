<template>
	<view>
		<!-- <markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="true"></markLayer> -->
		<headers from="bbs"></headers>
		<!--引用组件-->
		<u-skeleton :loading="loading" :animation="true" bgColor="#FFF"></u-skeleton>
		<!-- 骨架屏 -->
		<view class="u-skeleton" v-if="loading">
			<view class="flex itc fz30 c6 h110">
				<view class="t_list u-skeleton-fillet">ALL</view>
				<view class="t_list u-skeleton-fillet">Poular</view>
				<view class="t_list u-skeleton-fillet">Gardening Tips</view>
				<view class="t_list u-skeleton-fillet">Poular</view>
			</view>
			<!-- 列表 -->
			<view class="p0_30">
				<view class="bb1 mt20" v-for="item in 10">
					<view class="flex itc mb20">
						<view class=" mr20">
							<image src="../../static/images/i_06.jpg" mode="widthFix" class="avt u-skeleton-circle">
							</image>
						</view>
						<view class="flex_1 fz30 mr20 c3">
							<view class="flex itc">
								<view class=" oh1 mr20"><text class="u-skeleton-fillet">Beenda Hernandez</text> </view>
								<view class="level flex_1">
									<image src="../../static/images/l1.png" mode="widthFix"
										class="l1 u-skeleton-fillet"></image>
								</view>
							</view>
							<view class="fz24 c9 mt10"><text class="u-skeleton-fillet">2019-08-19 09:33:19</text></view>
						</view>
						<!-- 关注 -->
						<view class="follow_btn flex itc juc btn_bg u-skeleton-fillet">
							<view class="iconjia cf fz18 mr5"></view>
							<view class="fz28 cf">follow</view>
						</view>
					</view>
					<!--  -->
					<view class="flex itc">
						<view class="flex_1 mr30">
							<view class="fz34 c3 mb10 oh2 u-skeleton-fillet">牡丹芍药，种花得花，一粒种子就能种出来。开花比脸还要大</view>
							<!-- 标签 -->
							<view class="flex oh itc mt10 " style="max-width: 400rpx;">
								<view class="tag fz22 ca u-skeleton-fillet">flower</view>
								<view class="tag fz22 ca u-skeleton-fillet">tag</view>
							</view>
							<!--  -->
							<view class="flex itc h90" style="justify-content: space-between;">
								<view class="">
									<view class="flex itc">
										<view class="iconnice-line c9 fz30 mr10 u-skeleton-fillet"></view>
										<view class="fz24 c9 u-skeleton-fillet">1544</view>
									</view>
								</view>
								<view class="">
									<view class="flex itc">
										<view class="iconpinglun c9 fz24 mr10 u-skeleton-fillet"></view>
										<view class="fz24 c9 u-skeleton-fillet">1544</view>
									</view>
								</view>
								<view class="">
									<view class="flex itc">
										<view class="iconyanjing c9 fz32 mr10 u-skeleton-fillet"></view>
										<view class="fz24 c9 u-skeleton-fillet">15441</view>
									</view>
								</view>
							</view>
						</view>
						<!-- 图片 -->
						<view>
							<view class="">
								<image src="../../static/images/i_03.jpg" mode="" class="big_img u-skeleton-fillet">
								</image>
							</view>
						</view>
					</view>
					<view class="h20"></view>

				</view>

			</view>
		</view>
		<!-- 骨架屏结束 -->
		<view v-if="!loading">
			<swiperList :tabs="tabList" :parentHeight="parentHeight" pageFrom="bbs"
				requestUrl="/V1.CommunityArticle/index">
			</swiperList>
		</view>
	</view>
</template>

<script>
	// import minxin from '@/static/js/mixins.js';
	// 引入mescroll-mixins.js
	import headers from '@/components/header/header.vue';
	import swiperList from "@/components/swiperList/swiperList.vue";
	var _list = [{
		name: 'Community',
		id: 1
	}, {
		name: 'Poular',
		id: 2
	}, {
		name: 'Gardening Tips',
		id: 3
	}, {
		name: 'Gardening',
		id: 4
	}, {
		name: 'Tips',
		id: 5
	}];
	export default {
		data() {
			return {
				sys: "", //系统信息
				statusBarHeight: 0, //状态栏高度
				windowHeight: 0, //窗口可用高度
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: false, //是否显示页面遮罩 
				markType: 1, //1=加载页 2=请求失败 3=没有网络
				url: this.requestSet.ajaxUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				loading: true, //骨架屏 标志
				tabList: [],
				parentHeight: ""
			}
		},
		onLoad() {
			this.sys = uni.getSystemInfoSync();
			this.windowHeight = this.sys.windowHeight;
			this.statusBarHeight = this.sys.statusBarHeight;
			// 计算 内容区域高度
			this.parentHeight = `calc(${this.windowHeight}px - ${this.statusBarHeight}px - 44px)`
			this.getList();
		},
		onShow() {

		},
		components: {
			headers,
			swiperList
		},
		methods: {
			//获取精选列表
			getSelected() {
				var datas = {
					limit: 100,
					page: 1,
					is_under: 2,
				};
				this.requestSet.getData(datas, '/V1.CommunityCate/index', 'POST').then((res) => {
					if (res.status == 200) {
						this.tabList = res.data.list;
						this.getList();
					} else {
						this.$r.showToast('暂无内容')
					}
				}).catch((err) => {
					this.backFn();
					this.markType = 2;
					this.isLoad = false;
					this.loading = false;
				});
			},
			//获取分类
			getList() {
				var datas = {
					limit: 100,
					page: 1,
					is_under: 2,
				};
				this.requestSet.getData(datas, '/V1.CommunityCate/index', 'POST').then((res) => {
					if (res.status == 200) {
						var _reList = []
						if (this.reStatus.is_community == 1) {
							_reList.push({
								cate_id: "3",
								cate_name: "Popular",
								discover_cate_id: "3",
								sort: "3",
								status: "1",
								is_re: 1,
							})
						}
						var _list = res.data.list;
						var _aaa = _list.filter((item)=>{
							return item.status == 1
						})
						// console.log(_aaa)
						this.tabList = _reList.concat(_aaa);
					} else {
						this.$r.showToast('暂无内容')
					}
					setTimeout(() => {
						this.loading = false;
					}, 1000)
				}).catch((err) => {
					this.backFn();
					this.markType = 2;
					this.isLoad = false;
					this.loading = false;
				});
			},

			//请求返回方法
			backFn(backType) {

				if (backType === 1) { //请求成功
					this.isShow = false;
				} else if (backType === 0) { //请求失败
					this.isShow = false;
					this.isMark = true;
					this.markType = 2;
				}
			},
			nav(url) {
				uni.navigateTo({
					url: url
				})
			},
			refresh(data) { //刷新当前页数据
				if (data == this.timestamp) {
					uni.showLoading({
						title: 'Loading',
						mask: true
					})
					this.getList();
				}
			},
		},
	}
</script>
<style>
	page {
		width: 100%;
		overflow-x: hidden;
	}

	.t_list {
		margin-left: 30rpx;
		margin-right: 30rpx;
	}

	.h110 {
		height: 110rpx;
	}

	/* 列表 */
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
		line-height: 36rpx;
		border-radius: 18rpx;
		border: 1rpx #48ceb5 solid;
		padding: 0 20rpx;
	}

	/* 结束 */
	.swiper_box {
		width: 100%;
		background-color: #fff;
		overflow: hidden;
	}
</style>
