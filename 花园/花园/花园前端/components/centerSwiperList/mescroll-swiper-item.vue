<template>
	<!-- 
	swiper中的transfrom会使fixed失效,此时用height="100%"固定高度; 
	swiper中无法触发mescroll-mixins.js的onPageScroll和onReachBottom方法,只能用mescroll-uni,不能用mescroll-body
	-->
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<mescroll-uni ref="mescrollRef" @init="mescrollInit" :fixed="true" :down="downOption" @down="downCallback" :up="upOption"
		 @up="upCallback" @emptyclick="emptyClick">
			<view class="p0_30 bgf oh">
				<!-- 通知1 -->
				<view v-if="tabs[i].template == 'Replv'">
					<tab1 :componentsIndex="tabs[i]" :list="list"></tab1>
				</view>
				<!-- 通知2 -->
				<view v-if="tabs[i].template == 'message'">
					<tab2 :componentsIndex="tabs[i]" :list="list"></tab2>
				</view>
				<!-- 通知3 -->
				<view v-if="tabs[i].template == 'recommend'">
					<tab3 :componentsIndex="tabs[i]" :list="list"></tab3>
				</view>
				<!-- 发现 -->
				<view v-if="tabs[i].template == 'Discover'">
					<indexList :componentsIndex="tabs[i]" :list="list" :showlookNum="false"></indexList>
				</view>
				<!-- 论坛 -->
				<view v-if="tabs[i].template == 'BBS'">
					<bbsList :componentsIndex="tabs[i]" :list="list"></bbsList>
				</view>
				<!-- 问答 -->
				<view v-if="tabs[i].template == 'QA'">
					<qaList :componentsIndex="tabs[i]" :list="list"></qaList>
				</view>
				<!-- 我发布的bbs -->
				<view v-if="tabs[i].template == 'my'">
					<bbsList :componentsIndex="tabs[i]" :list="list" :showEdidBtn="true"></bbsList>
				</view>
				<!-- 我参与的帮bbs -->
				<view v-if="tabs[i].template == 'from'">
					<bbsList :componentsIndex="tabs[i]" :list="list" :showEdidBtn="false"></bbsList>
				</view>
				<!-- 我发布的问答 -->
				<view v-if="tabs[i].template == 'myQa'">
					<myQA :componentsIndex="tabs[i]" :list="list"></myQA>
				</view>
				<!-- 我参与的问答 -->
				<view v-if="tabs[i].template == 'fromQa'">
					<fromQA :componentsIndex="tabs[i]" :list="list"></fromQA>
				</view>
			</view>

		</mescroll-uni>
	</view>

</template>

<script>
	// 请注意  上拉和下拉回调中  必须重新定义this=this，因为插件this指向不同
	import MescrollMixin from "@/components/mescroll-uni/mescroll-mixins.js";
	import MescrollMoreItemMixin from "@/components/mescroll-uni/mixins/mescroll-more-item.js";
	// Replv to me 模板
	import tab1 from "@/pages/center/notification/tab1.vue";
	// System message 模板
	import tab2 from "@/pages/center/notification/tab2.vue";
	// recommend 模板
	import tab3 from "@/pages/center/notification/tab3.vue";
	// 发现
	import indexList from "@/components/indexList/indexList.vue";
	// 论坛
	import bbsList from "@/pages/center/bbs/tab1.vue";
	// 问答
	import qaList from "@/components/qaList/qaList.vue";
	// 我发布的问答
	import myQA from "@/pages/center/qa/tab1.vue";
	// 我参与的问答
	import fromQA from "@/pages/center/qa/tab2.vue";
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
			}
		},
		computed: {},
		created() {
			// console.log(this.tabs[this.i])
		},
		components: {
			tab1,
			tab2,
			tab3,
			indexList,
			bbsList,
			qaList,
			myQA,
			fromQA
		},
		/*
			tabs = 分类数据
			i = 当前组件索引
			index = swiper当前 索引
		*/
		props: ['tabs', 'i', 'index'],
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
				// 当前分类数据
				var _classData = this.tabs[this.i];
				console.log(_classData);
				// console.log(this.pageFrom)
				// 判断页面区分请求参数
				var datas = {};
				// 我收藏的Discover
				if (_classData.template == "Discover") {
					datas = {
						page: page.num,
						limit: this.requestSet.pageSize,
						type: 1
					};
				} else if (_classData.template == "BBS") {
					// 我收藏的BBS
					datas = {
						page: page.num,
						limit: this.requestSet.pageSize,
						type: 2
					};
				} else if (_classData.template == "QA") {
					// 我收藏的QA
					datas = {
						page: page.num,
						limit: this.requestSet.pageSize,
						type: 3
					};
				} else if (_classData.template == "my") {
					// 我发布的BBS
					datas = {
						page: page.num,
						limit: this.requestSet.pageSize,
					};
				} else if (_classData.template == "from") {
					// 我参与的BBS
					datas = {
						page: page.num,
						limit: this.requestSet.pageSize,
					};
				} else if (_classData.template == "myQa") {
					// 我发布的qa
					datas = {
						page: page.num,
						limit: this.requestSet.pageSize,
					};
				} else if (_classData.template == "fromQa") {
					// 我参与的qa
					datas = {
						page: page.num,
						limit: this.requestSet.pageSize,
					};
				} else if (_classData.template == "Replv") {
					// bbs 和qa  获得的评论
					datas = {
						page: page.num,
						limit: this.requestSet.pageSize,
					};
				} else if (_classData.template == "message") {
					// 系统公告
					datas = {
						page: page.num,
						limit: this.requestSet.pageSize,
					};
				} else if (_classData.template == "recommend") {
					// 消息-推荐文章
					datas = {
						apipage: "main",
						op: "recom",
						pageindex: page.num,
						pagesize: this.requestSet.pageSize,
						tokenstr: this.token
					};
				}
				this.requestSet.getData(datas, _classData.ajaxUrl, 'GET').then((res) => {
					// 通知消息的列表单独处理
					if(res.status == 200) {
						// 我发布的Qa和我回答的Qa 
						if (page.num == 1) {
							this.data = [];
						};
						this.list = this.data.concat(res.data.list);
						// 
						
						
					}else {
						this.$r.showToast(res.msg)
					}
					this.backFn(res.data.list.length);
				}).catch((err) => {
					console.log(err)
					this.isMark = true;
					this.markType = 2;
					this.mescroll.endErr();
				});


			},
			backFn(length) {
				setTimeout(() => {
					this.isMark = false;
					this.mescroll.endSuccess(length);
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
