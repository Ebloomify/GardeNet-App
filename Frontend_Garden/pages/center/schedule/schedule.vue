<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<view class="p30">
			<mescroll-uni ref="mescrollRef" @init="mescrollInit" :fixed="true" :down="downOption" @down="downCallback" :up="upOption"
			 @up="upCallback" @emptyclick="emptyClick">
				<view class="p30">
					<view class="pb20 mb20 bb1" v-for="(item,index) in list" @click="setStatic(item.id,item.flowerid,index)">
						<view class="flex itc pb10  mb20">
							<image :src="getIcon(item.name.split('-')[1])" mode="" style="width: 50rpx; height: 50rpx;"></image>
							<view class="fz32 c3 pl20">{{item.name.split('-')[1]}}</view>
						</view>
						<view class="flex itc">
							<view class="avt mr20">
								<!-- <image :src="url + getPic(item.pics)[0]" mode="aspectFill" v-if="getPic(item.pics)[0]" class="bor10 oh"></image> -->
								<img-cache v-if="getPic(item.pics)[0]" :src="url + getPic(item.pics)[0]" :customStyle="customStyle" width="100rpx"
								 height="100rpx" mode="aspectFill" bgSrc="../../static/images/loading1.png"></img-cache>
							</view>
							<view class="mr20 flex_1">
								<view class="fz30 c6 mb10 oh1">{{item.name.split('-')[0]}}</view>
								<view class="fz24 c6">{{item.addtime}}</view>
							</view>
							<view class="yuan"></view>
						</view>

					</view>

				</view>



			</mescroll-uni>

		</view>
	</view>
</template>

<script>
	var navList = [{
		name: 'Water',
		iconUrl: '../../../static/images/nicon1.png',
		url: '../../../static/images/f1.png'
	}, {
		name: 'Repot',
		iconUrl: '../../../static/images/nicon2.png',
		url: '../../../static/images/f2.png'
	}, {
		name: 'Prune',
		iconUrl: '../../../static/images/nicon3.png',
		url: '../../../static/images/f3.png'
	}, {
		name: 'Fertilizer',
		iconUrl: '../../../static/images/nicon4.png',
		url: '../../../static/images/f4.png'
	}, {
		name: 'Others',
		iconUrl: '../../../static/images/nicon5.png',
		url: '../../../static/images/f5.png'
	}, {
		name: 'Harvest',
		iconUrl: '../../../static/images/nicon6.png',
		url: '../../../static/images/f1.png'
	}, {
		name: 'Pesticides',
		iconUrl: '../../../static/images/nicon7.png',
		url: '../../../static/images/f3.png'
	}, {
		name: 'Sow',
		iconUrl: '../../../static/images/nicon8.png',
		url: '../../../static/images/f4.png'
	}]
	import MescrollMixin from "@/components/mescroll-uni/mescroll-mixins.js";
	import MescrollMoreItemMixin from "@/components/mescroll-uni/mixins/mescroll-more-item.js";
	export default {
		mixins: [MescrollMixin, MescrollMoreItemMixin], // 注意此处还需使用MescrollMoreItemMixin (必须写在MescrollMixin后面)
		data() {
			return {
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				downOption: {
					auto: false, // 不自动加载 (mixin已处理第一个tab触发downCallback)
					bgColor: "#48cfb2"
				},
				upOption: {
					auto: false, // 不自动加载
					page: {
						num: 0, // 当前页码,默认0,回调之前会加1,即callback(page)会从1开始
						size: 10 // 每页数据的数量
					},
					noMoreSize: 1, //如果列表已无数据,可设置列表的总数量要大于半页才显示无更多数据;避免列表数据过少(比如只有一条数据),显示无更多数据会不好看; 默认5
					empty: {
						icon: 'bgImg',
						tip: '暂时没有文章敬请期待',
						top: '260rpx'
					}
				},
				list: [], //列表数据
				customStyle: {
					borderRadius: '10rpx'
				}
			}
		},
		onLoad() {},
		methods: {
			setStatic(id, flowerid, index) {
				uni.showModal({
					title: 'Tips',
					content: 'Clear it?',
					confirmText: "Yes",
					cancelText: 'No',
					success: (res) => {
						if (res.confirm) {
							var datas = {
								apipage: "main",
								op: "time_info_edit",
								id: id,
								flowerid: flowerid,
								tokenstr: this.token
							};
							this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
								if (res.error == 0) {
									this.list.splice(index, 1);
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
			// 获取列表图标
			getIcon(str) {
				if (str) {
					console.log(str)
					for (var i = 0; i < navList.length; i++) {
						if (navList[i].name == str) {
							return navList[i].iconUrl;
						}
					}
				} else {
					return '';
				}

			},
			// 切割图片路径
			getPic(item) {
				if (item) {
					return item.split('^');
				} else {
					return [];
				};
			},
			mescrollInit(mescroll) {
				this.mescroll = mescroll;
				this.mescrollInitByRef && this.mescrollInitByRef(); // 兼容字节跳动小程序
				// 自动加载当前tab的数据
				this.isInit = true; // 标记为true
				this.mescroll.triggerDownScroll();
			},
			/*下拉刷新的回调 */
			downCallback() {
				// 这里加载你想下拉刷新的数据, 比如刷新轮播数据
				// loadSwiper();
				// 下拉刷新的回调,默认重置上拉加载列表为第一页 (自动执行 page.num=1, 再触发upCallback方法 )
				setTimeout(() => {
					this.mescroll.resetUpScroll()
				}, 500)
			},
			/*上拉加载的回调: 其中page.num:当前页 从1开始, page.size:每页数据条数,默认10 */
			upCallback(page) {
				// console.log(this.pageFrom)
				// 判断页面区分请求参数
				var datas = {
					apipage: "main",
					op: "timer_info",
					pageindex: page.num,
					pagesize: this.requestSet.pageSize,
					tokenstr: this.token
				};

				this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
					if (res.list) {
						this.mescroll.endSuccess(res.list.length);
						//如果是第一页需手动制空列表--并获取当前栏目广告内容
						if (page.num == 1) {
							this.list = [];
						};
						this.list = this.list.concat(res.list);
					} else {
						this.requestSet.showToast(res.returnstr);
					};
					this.isMark = false;
				}).catch((err) => {
					console.log(err)
					this.isMark = true;
					this.markType = 2;
					this.mescroll.endErr();
				});
				// setTimeout(() => {
				// 	this.isMark = false;
				// 	this.mescroll.endSuccess(1);
				// }, 100)

			},
			emptyClick() {
				uni.showToast({
					title: '点击了按钮,具体逻辑自行实现'
				})
			},
			refresh(data) { //刷新当前页数据
				if (data == this.timestamp) {
					this.mescroll.resetUpScroll();
				}
			},
		}
	}
</script>

<style>
	.avt {
		width: 100rpx;
		height: 100rpx;
	}

	.avt image {
		width: 100%;
		height: 100%;
		display: block;
	}

	.yuan {
		width: 20rpx;
		height: 20rpx;
		border-radius: 50%;
		border: #16D96D solid 4rpx;
	}
</style>
