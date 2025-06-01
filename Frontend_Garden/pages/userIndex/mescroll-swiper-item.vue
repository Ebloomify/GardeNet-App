<template>
	<!-- 
	swiper中的transfrom会使fixed失效,此时用height="100%"固定高度; 
	swiper中无法触发mescroll-mixins.js的onPageScroll和onReachBottom方法,只能用mescroll-uni,不能用mescroll-body
	-->
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<mescroll-uni ref="mescrollRef" @init="mescrollInit" :fixed="true" :down="downOption" @down="downCallback" :up="upOption"
		 @up="upCallback" @emptyclick="emptyClick" bottom="0" :isSroll="isSroll">
			<view class="p0_30 bgf oh">
				<!-- 论坛 -->
				<view v-if="tabs[i].template == 'BSS'">
					<bbsList :componentsIndex="tabs[i]" :list="infoData.community" :showUserInfo="false"></bbsList>
				</view>
				<!-- 问答 -->
				<view v-if="tabs[i].template == 'QA'">
					<qaList :componentsIndex="tabs[i]" :list="infoData.qa" :showUserInfo="false"></qaList>
				</view>
				<!-- 植物 -->
				<view v-if="tabs[i].template == 'garden'">
					<view class="h20"></view>
					<gardenList :componentsIndex="tabs[i]" :list="infoData.garden" :showUserInfo="false" :isLink="false"></gardenList>
				</view>
			</view>

		</mescroll-uni>
	</view>

</template>

<script>
	// 请注意  上拉和下拉回调中  必须重新定义this=this，因为插件this指向不同
	import MescrollMixin from "@/components/mescroll-uni/mescroll-mixins.js";
	import MescrollMoreItemMixin from "@/components/mescroll-uni/mixins/mescroll-more-item.js";
	// 论坛
	import bbsList from "@/components/bbsList/bbsList.vue";
	// 问答
	import qaList from "@/components/qaList/qaList.vue";
	// 植物
	import gardenList from "@/components/gardenList/gardenList.vue";
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
					bgColor: "#48cfb2",
					isLock: true
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
			}
		},
		computed: {},
		created() {
			// console.log(this.tabs[this.i])
		},
		components: {
			bbsList,
			qaList,
			gardenList
		},
		/*
			tabs = 分类数据
			i = 当前组件索引
			index = swiper当前 索引
			isSroll= 是否可以滚动
			userId= 当前用户id
		*/
		props: ['tabs', 'i', 'index', 'isSroll','userId','infoData'],
		methods: {
			// 监听增加观看量

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
				this.backFn();
				return;
				var datas = {
					apipage: "userindex",
					userid: this.userId,
					tokenstr: this.token
				};
				this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
					var _classData = this.tabs[this.i];
					if (res.error == 0) {
						//如果是第一页需手动制空列表--并获取当前栏目广告内容
						if (page.num == 1) {
							this.list = [];
						};
						if (_classData.template == 'BSS') {
							this.mescroll.endSuccess(res.bbslist.length);
							this.list = this.list.concat(res.bbslist);
						} else if (_classData.template == 'QA') {
							this.mescroll.endSuccess(res.qalist.length);
							this.list = this.list.concat(res.qalist);
						} else if (_classData.template == 'garden') {
							this.mescroll.endSuccess(res.gardenlist.length);
							this.list = this.list.concat(res.gardenlist);
						}
					} else {
						this.requestSet.showToast(res.returnstr);
					};
					this.backFn();
				}).catch((err) => {
					console.log(err)
					this.isMark = true;
					this.markType = 2;
					this.mescroll.endErr();
				});
			},
			backFn() {
				setTimeout(() => {
					this.isMark = false;
					this.mescroll.endSuccess(1);
				}, 100)
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
	swiper {
		height: 420rpx;
	}

	.banner_img_box {
		height: 420rpx;
		position: relative;
	}

	.banner_img_box image {
		width: 100%;
		height: 420rpx;
		display: block;
	}

	.banner_info {
		position: absolute;
		width: 100%;
		left: 0;
		bottom: 0;
		height: 120rpx;
	}

	.banner_info .p20 {
		position: absolute;
		left: 0;
		bottom: 0;
		z-index: 2;
	}

	.bg_mark {
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		z-index: 1;
		background: -webkit-linear-gradient(top, transparent, #000);
		opacity: 0.7;
	}

	.p30_0 {
		padding: 30rpx 0;
	}

	.new_tag {
		width: 60rpx;
		height: 30rpx;
		text-align: center;
		line-height: 30rpx;
		border: 2rpx solid #00499d;
		border-radius: 5rpx;
		overflow: hidden;
	}

	.img1 {
		width: 228rpx;
		height: 128rpx;
		border: 3rpx;
	}

	.list_img {
		width: 100%;
		height: 100%;
		display: block;
	}

	.mr5 {
		margin-right: 5rpx;
	}

	.img2 {
		width: 100%;
		height: 388rpx;
		border-radius: 10rpx;
	}

	.sle {
		width: 30%;
	}

	.active {
		background-color: #f7f7f7;
		color: #333;
	}
</style>
