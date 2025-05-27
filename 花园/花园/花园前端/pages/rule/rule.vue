<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<view class="p20" v-if="param.keyword == 'rule1' && info.ag">
			<view class="fz32 c3 fw9 mb10">{{info.ag.ag_title}}</view>
			<!-- <view class="fz28 c9">{{info[0].Addtime}}</view> -->
			<view class="h20"></view>
			<view class="lh50 c3">
				<u-parse :html="info.ag.ag_body" :domain="$r.imgUrl"></u-parse>
			</view>
		</view>
		<view class="p20" v-if="param.keyword == 'rule2' && info.ag2">
			<view class="fz32 c3 fw9 mb10">{{info.ag2.ag_title2}}</view>
			<!-- <view class="fz28 c9">{{info[0].Addtime}}</view> -->
			<view class="h20"></view>
			<view class="lh50 c3">
				<u-parse :html="info.ag2.ag_body2" :domain="$r.imgUrl"></u-parse>
			</view>
		</view>
		
		<view class="p20" v-if="param.keyword == 'about'">
			<view class="fz32 c3 fw9 mb10">About GardeNet</view>
			<!-- <view class="fz28 c9">{{info[0].Addtime}}</view> -->
			<view class="h20"></view>
			<view class="lh50 c3">
				<u-parse :html="info.about" :domain="$r.imgUrl"></u-parse>
			</view>
		</view>
		
		<view class="p20" v-if="param.keyword == 'shopInfo'">
			<view class="fz32 c3 fw9 mb10">Points mall</view>
			<!-- <view class="fz28 c9">{{info[0].Addtime}}</view> -->
			<view class="h20"></view>
			<view class="lh50 c3">
				<u-parse :html="info.config" :domain="$r.imgUrl"></u-parse>
			</view>
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
				info: {}
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
				var _url;
				if(this.param.keyword == 'shopInfo') {
					_url = '/V1.IntegerShop/info'
				} else {
					_url = '/Config/list'
				}
				this.requestSet.getData(datas, _url, 'GET').then((res) => {
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

</style>
