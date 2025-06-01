<template>
	<view>
		<view class="">
			<view class="list boxSha bor10 bgf p0_20 mt40" v-for="(item,index) in list" @click="nav(item)">
				<view class="fz32 c3 pt20 mb10">{{item.name}}</view>
				<view class="fz22 c9">{{item.addtime}}</view>
				<view class="h20"></view>
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
		props:{
			list: {
				type: Array,
				default: []
			}
		},
		methods: {
			nav(item){
				uni.navigateTo({
					url: "/pages/info/info?fromType=discover&id=" +item.id
				})
			}
		}
	}
</script>

<style>
	.p0_20{
		padding: 0 20rpx;
	}
	.mt40{
		margin-top: 40rpx;
	}
</style>
