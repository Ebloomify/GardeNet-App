const MescrollMixin = {
	// components: { // 非H5端无法通过mixin注册组件, 只能在main.js中注册全局组件或具体界面中注册
	// 	MescrollUni,
	// 	MescrollBody
	// },
	data() {
		return {
			list: [],
			pageIndex: 1,
			isLoad: false, //正在加载
			isMore: true, //是否还有数据
		}
	},
	// 注册系统自带的下拉刷新 
	onPullDownRefresh() {
		// this.pageIndex = 1;
		// this.getList();
	},
	// 注册列表滚动事件
	onPageScroll(e) {

	},
	// 注册滚动到底部的事件,用于上拉加载
	onReachBottom() {
		//不在加载中 并且 还有更多数据
		if (!this.isLoad && this.isMore) {
			this.getList();
		}
	},
	methods: {
		//判断是否还有更多数据
		getNextPage(list) {
			//列表长度 等于 分页数量长度
			if (list.length == this.requestSet.pageSize) {
				this.pageIndex++;
			} else {
				this.isMore = false;
			};
			this.isLoad = false;
		}
	},
}

export default MescrollMixin;
