<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<!--  -->
		<view>
			<mescroll-uni ref="mescrollRef" @init="mescrollInit" :fixed="true" :down="downOption" @down="downCallback" :up="upOption"
			 @up="upCallback" @emptyclick="emptyClick" top="0">
				<view class="p30">
					<view v-if="param.type == 'discover'">
						<indexList :list="list"></indexList>
					</view>

					<view v-if="param.type == 'bbs'">
						<bbsList :list="list"></bbsList>
					</view>

					<view v-if="param.type == 'qa'">
						<qa :list="list"></qa>
					</view>
				</view>
			</mescroll-uni>
		</view>
	</view>
</template>

<script>
	import MescrollMixin from "@/components/mescroll-uni/mescroll-mixins.js";
	// import indexList from "@/components/indexList/indexList.vue";
	// import bbsList from "@/components/bbsList/bbsList.vue";
	// import qaList from "@/components/qaList/qaList.vue";
	export default {
		mixins: [MescrollMixin], // 注意此处还需使用MescrollMoreItemMixin (必须写在MescrollMixin后面)
		data() {
			return {
				param: {},
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				downOption: {
					auto: true, // 不自动加载 (mixin已处理第一个tab触发downCallback)
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
						tip: 'no List',
						top: '260rpx'
					}
				},
				list: [], //列表数据
				customStyle: {
					borderRadius: '50%'
				},
				param: {}
			}
		},
		onLoad(option) {
			this.param = option;
			if (option.keyWord) {
				uni.setNavigationBarTitle({
					title: option.keyWord
				})
			};
		},
		methods: {
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
				// 判断页面区分请求参数
				var datas = {
					apipage: this.param.type,
					op: 'list', // ""
					pageindex: page.num,
					pagesize: this.requestSet.pageSize,
					keyword: this.param.keyWord
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

</style>
