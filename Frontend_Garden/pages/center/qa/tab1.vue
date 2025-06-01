<template>
	<view>
		<view class="bb1 p20_0 box" v-for="(item,index) in list" @click="toInfo(item)">
			<view class="fz30 mb20" style="color: #FAD812;" v-if="item.auth_status == 2">Under review</view>
			<view class="fz30 mb20" style="color: #FF1A1A;" v-if="item.auth_status == 0">Audit failed : <text class="fz26 pl10">{{item.auth_msg}}</text></view>
			<view class="flex">
				<view class="flex_1 mr20">
					<view class="fz34 c3">
						{{item.title}}
					</view>
					<view class="mb10">
						<text class="fz22 c9">{{item.create_time}}</text>
					</view>
					<!-- 未结束状态 -->
					<view class="mr30">
						<view class="flex itc">
							<view class="mr10">
								<image src="../../../static/images/qa1.jpg" mode="" style="width: 35rpx; height: 35rpx;display: block;"></image>
							</view>
							<view class="fz26" style="color: #ffd03a;">{{item.integer_sum}}</view>
						</view>
					</view>
					<!--  -->
					<view class="fz24 c3 flex itc mt10">
						<view class="fz26 ca" v-if="item.resolved_status == 1">unresolved</view>
						<view class="fz26 ca" v-else>Resolved</view>
					</view>
				</view>
				<!--  -->
				<view class="" v-if="item.resolved_status == 1">
					<u-button type="primary" size="mini" :ripple="true" @click="edit(item)">edit</u-button>
				</view>
			</view>
			
		</view>

		<!-- <view class="bb1 p20_0 box" v-for="(item,index) in list">
			<view class="fz34 c3">
				芍药牡丹，该怎么种植呢？花上有水咋办？
			</view>
			<view class="mb10">
				<text class="fz22 c9">2019-08-19 09:33:19</text>
			</view>
			<view class="mr30">
				<view class="flex itc">
					<view class="mr10">
						<image src="../../../static/images/qa1.jpg" mode="" style="width: 35rpx; height: 35rpx;display: block;"></image>
					</view>
					<view class="fz26" style="color: #ffd03a;">100</view>
				</view>
			</view>
			<view class="fz24 c3 flex itc mt10">
				<view v-if="index == 0">View 1 reply </view>
				<view v-else>No reply</view>
				<view class=" ml10 mr20">
					<text class="icontriangle-right c3" style="height: 22rpx; overflow: hidden;" v-if="index == 0"></text>
				</view>
				<view class="fz26 ca" v-if="index == 0">have in hand</view>
				<view class="fz26 ca" v-else>Resolved</view>
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
					// url: "/pages/info/info?fromType=qa&showQaBtn=true&id=" + item.id
					url: "/pages/qa/qaInfo?fromType=qa&showQaBtn=true&id=" + item.question_id
				})
			},
			edit(item){
				uni.navigateTo({
					url:"/pages/add/bbs?from=qa&item=" + JSON.stringify(item) +"&id=" +item.question_id
				})
			}
		}
	}
</script>

<style>
	.p20_0 {
		padding: 20rpx 0;
	}

	.box {
		position: relative;
	}

	.active {
		transform: rotate(-20deg);
		width: 200rpx;
		position: absolute;
		right: -10rpx;
		bottom: 40rpx;
	}
</style>
