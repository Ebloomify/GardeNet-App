<template>
	<view>
		<view class="tac">
			<image src="../../../static/images/no_03.jpg" mode="" class="img"></image>
			<view class="h20"></view>
			<view class="fz30 c6">{{content || 'No Data'}}</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				
			}
		},
		props:['content'],
		methods: {
			
		}
	}
</script>

<style>
	.img{
		width: 421rpx;
		height: 317rpx;
		display: block;
		margin: auto;
		margin-top: 170rpx;
	}
</style>
