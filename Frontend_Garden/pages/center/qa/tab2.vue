<template>
	<view>
		
		<view class="bb1 p20_0 box" v-for="(item,index) in list"  @click="toInfo(item)">
			<image src="../../../static/images/select.png" mode="widthFix" class="active" v-if="item.is_accept == 1"></image>
			<view class="flex mb10">
				<view class="fz30 c3 flex_1 mr40">Q：{{item.q_content}}</view>
				<!-- <view class="ca fz30" v-if="item.resolved_status == 1">have in hand</view> -->
				<view class="ca fz30" v-if="item.resolved_status == 1">unresolved</view>
				<view class="ca fz30" v-else>Resolved</view>
			</view>
			<view class="fz30 c9 mb20">A：{{item.a_content}}</view>
			<view class="fz24 c9 mb20">{{$r.initTime(item.create_time * 1000)}}</view>
			<view class="mr30">
				<view class="flex itc">
					<view class="mr10">
						<image src="../../../static/images/qa1.jpg" mode="" style="width: 35rpx; height: 35rpx;display: block;"></image>
					</view>
					<view class="fz26" style="color: #ffd03a;">{{item.integer_sum}}</view>
				</view>
			</view>
		</view>
		
		
		<!-- <view class="bb1 p20_0 box" v-for="(item,index) in 2">
			<image src="../../../static/images/select.png" mode="widthFix" class="active" v-if="index == 1"></image>
			<view class="flex mb10">
				<view class="fz30 c3 flex_1 mr40">Q：想问问我这个花到底是怎么了</view>
				<view class="ca fz30" v-if="index == 0">have in hand</view>
				<view class="ca fz30" v-else>Resolved</view>
			</view>
			<view class="fz30 c9 mb20">A：你这可能是花瓣病菌，重新种一颗就好了</view>
			<view class="fz24 c9 mb20">2020.10.20</view>
			<view class="mr30">
				<view class="flex itc">
					<view class="mr10">
						<image src="../../../static/images/qa1.jpg" mode="" style="width: 35rpx; height: 35rpx;display: block;"></image>
					</view>
					<view class="fz26" style="color: #ffd03a;">100</view>
				</view>
			</view>
		</view> -->
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
			toInfo(item) {
				uni.navigateTo({
					url: "/pages/qa/qaInfo?fromType=qa&id=" + item.question_id
				})
			}
		}
	}
</script>

<style>
	.p20_0{
		padding: 20rpx 0;
	}
	.box{
		position: relative;
	}
	
	.active{
		transform: rotate(-20deg);
		width: 200rpx;
		position: absolute;
		right: -10rpx;
		bottom: 50rpx;
	}
	.mr40{
		margin-right: 40rpx;
	}
</style>
