<template>
	<view>
		<view class="">
			<view class="list boxSha bor10 bgf p0_20 mt20 mb20" v-for="(item,index) in list" @click="nav(item)">
				<view class="fz32 c3 pt20 pb10 title">{{item.msg_title}}</view>
				<view class="fz22 c9">{{$r.initTime(item.create_time * 1000)}}</view>
				<!-- <view class="fz28 c6">{{item.msg_title}}</view> -->
				<view class="h20"></view>
				<view class="read" v-show="item.is_read == 0"></view>
			</view>
			<view class="h10"></view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {

			}
		},
		props: {
			list: {
				type: Array,
				default: []
			}
		},
		methods: {
			setRead(item) {
				var datas, _url;
				// console.log(this.param)
				datas = {
					id: item.broadcast_id,
					type: 3,
				};
				_url = '/V1.Notification/read';
				this.requestSet.getData(datas, _url, 'GET').then((res) => {
					if (res.status == 200) {
						item.is_read = 1;
					} else {
						this.requestSet.showToast(res.msg);
					}
					
				}).catch((err) => {
					
				});
			},
			nav(item) {
				uni.setStorageSync('sysInfo',item);
				uni.navigateTo({
					// url: '/pages/center/notification/info?item=' + encodeURI(JSON.stringify(item))
					url: '/pages/center/notification/info?item='
				})
				this.setRead(item) 
			}
		}
	}
</script>

<style>
	.p0_20 {
		padding: 0 20rpx;
	}

	.mt40 {
		margin-top: 40rpx;
	}
	.list{
		position: relative;
	}
	
	.read{
		position: absolute;
		width: 20rpx;
		height: 20rpx;
		border-radius: 50%;
		background: red;
		top: 10rpx;
		left: 10rpx;
	}
	
	.title{
	}
</style>
