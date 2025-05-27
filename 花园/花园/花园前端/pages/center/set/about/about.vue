<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<view class="logo flex itc juc">
			<image src="../../../../static/images/logo.png" mode=""></image>
		</view>
		<view class="h10 bgf4"></view>
		<view class="p30 fz28 c9">
			<u-parse :html="info.about" :domain="$r.imgUrl"></u-parse>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				param: {},
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				info: ""
			}
		},
		onLoad(option) {
			this.param = option;
			this.getList();
		},
		methods: {
			getList() {
				var datas = {
					// apipage: "newslist",
					// keyword: this.param.keyword
				};
				this.requestSet.getData(datas, "/Config/list", 'GET').then((res) => {
					if (res.status == 200) {
						this.info = res.data;
					} else {
						this.requestSet.showToast(res.msg);
					}
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
		}
	}
</script>
<style>
	.logo{
		height: 360rpx;
	}
	.logo image{
		width: 115rpx;
		height: 115rpx;
	}
</style>
