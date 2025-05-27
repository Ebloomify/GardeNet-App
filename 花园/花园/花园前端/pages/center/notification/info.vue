<template>
	<view>
		<!-- <markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer> -->
		<view class="p20">
			<view class="fz32 c3 fw9 mb10">{{info.msg_title}}</view>
			<view class="fz28 c9">{{$r.initTime(info.create_time * 1000)}}</view>
			<view class="h20"></view>
			<view class="lh50 c3">
				<u-parse :html="info.msg_content" :domain="$r.imgUrl" :lazy-load="true"
						loading-img="../../../static/images/loading1.png"></u-parse>
			</view>
			<!-- <view v-else>
				<view class="h100"></view>
				<view class="lh100 fz28 c9">暂无协议</view>
			</view> -->

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
			// this.param = JSON.parse(option.item);
			// this.param = JSON.parse(decodeURI(option.item));
			var _info = uni.getStorageSync('sysInfo');
			
			this.info = _info;
		},
		methods: {
			getList() {
				var datas, _url;
				// console.log(this.param)
				datas = {
					id: this.param.id,
					type: 3,
				};
				_url = '/V1.Notification/read';
				this.requestSet.getData(datas, _url, 'GET').then((res) => {
					if (res.status == 200) {
						
					} else {
						this.requestSet.showToast(res.msg);
					}
					
				}).catch((err) => {
					
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
