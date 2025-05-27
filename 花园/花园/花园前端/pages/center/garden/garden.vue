<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<view class="p30">
			<mescroll-uni ref="mescrollRef" @init="mescrollInit" :fixed="true" :down="downOption" @down="downCallback"
				:up="upOption" @up="upCallback" @emptyclick="emptyClick">
				<view style="padding:30rpx;">
					<view class="list boxSha boxSha bor20 mb30 p20 flex itc" v-for="(item,index) in list"
						@click="nav(item)">
						<view class="avt mr30">
							<!-- <image :src="url + getPic(item.pics)[0]" mode="aspectFill" v-if="getPic(item.pics)[0]" class="bor10 oh"></image> -->
							<img-cache :src="url + getPic(item.img)[0]"
								:customStyle="customStyle" width="160rpx" height="160rpx" mode="aspectFill"
								bgSrc="../../static/images/loading1.png"></img-cache>
						</view>
						<view class="flex_1">
							<view class="fz34 c3 oh1">{{item.plant_name}}</view>
							<view class="fz28 c6 oh1 mb10">{{item.plant_introduction}}</view>
							<view class="flex itc">
								<view class="yuan tac lh50 mr20" style="background-color: #48ceb7;"
									@click.stop="edit(item)">
									<view class="icontubiao09"></view>
								</view>
								<view class="yuan tac lh50 mr20" style="background-color: #f27272;"
									@click.stop="del(item.id,index)">
									<view class="iconshanchu"></view>
								</view>
							</view>
						</view>

					</view>
				</view>



			</mescroll-uni>

		</view>
	</view>
</template>

<script>
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
						tip: 'No List',
						top: '260rpx'
					}
				},
				list: [], //列表数据
				customStyle: {
					borderRadius: '10rpx'
				}
			}
		},
		onLoad() {
			uni.$on('refreshCenter', () => {
				this.mescroll.resetUpScroll()
			});
			uni.$on('delGarden', (id) => {
				console.log(this.list)
				for (var i = 0; i < this.list.length; i++) {
					if (this.list[i].id == id) {
						this.list.splice(i, 1);
					}
				}
			});
		},
		onUnload() {
			this.$off('refreshCenter');
			this.$off('delGarden');
		},
		onNavigationBarButtonTap(e) {
			if (e.float == "right") {
				uni.navigateTo({
					url: "/pages/center/garden/add"
				})
			}
		},
		methods: {
			del(id, index) {
				uni.showModal({
					title: 'Tips',
					content: 'Confirm deletion',
					confirmText: "OK",
					cancelText: "Cancel",
					success: (res) => {
						if (res.confirm) {
							uni.showLoading({
								title: 'Loading',
								mask: true,
							});
							var datas = {
								ids: id
							};
							this.requestSet.getData(datas, '/V1.Garden/delete', 'DELETE').then((res) => {
								if (res.status == 200) {
									this.list.splice(index, 1);
								} else {
									this.requestSet.showToast(res.msg);
								};
							}).catch((err) => {

							});
						}
					}
				});
			},
			// 修改
			edit(item) {
				uni.navigateTo({
					url: '/pages/center/garden/add?id=' + item.id
				})
			},
			nav(item) {
				// '/pages/center/garden/info
				if (!this.userInfo) {
					this.login();
				} else {
					uni.navigateTo({
						url: "/pages/center/garden/info?id=" + item.id,
					})
				}

			},
			// 切割图片路径
			getPic(item) {
				if(item) {
					return item.split(',')
				}
				return []
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
					page: page.num,
					limit: this.requestSet.pageSize,
				};

				this.requestSet.getData(datas, '/V1.Garden/list', 'GET').then((res) => {
					if (res.status == 200) {
						this.mescroll.endSuccess(res.data.list.length);
						//如果是第一页需手动制空列表--并获取当前栏目广告内容
						if (page.num == 1) {
							this.list = [];
						};
						this.list = this.list.concat(res.data.list);
					} else {
						this.requestSet.showToast(res.msg);
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
		width: 160rpx;
		height: 160rpx;
	}

	.avt image {
		width: 100%;
		height: 100%;
		display: block;
	}

	.yuan {
		width: 50rpx;
		height: 50rpx;
		border-radius: 50%;
		font-size: 30rpx;
		color: #fff;
	}

	.list {}
</style>
