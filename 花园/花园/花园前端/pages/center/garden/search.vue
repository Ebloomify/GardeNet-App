<template>
	<view>
		<u-navbar>
			<view class="search_box mr20 flex_1">
				<view class="flex itc p0_40 h70">
					<view class="iconsousuo fz40 c9 mr20"></view>
					<input maxlength="-1"  type="text" class="w100 fz32 c3 flex_1" placeholder="Enter the plant name" v-model="searchName" @confirm="getList">
				</view>
			</view>
			<view slot="right">
				<view class="ca fz28 pr20" @click="getList">search</view>
			</view>
		</u-navbar>
		<!--  -->
		<view class="p30">
			<view class="fz26 c9  mb40">Please select from the list below</view>
			<view class="">
				<view class="flex itc fz28 c3 bb1 h90" v-for="item in list" @click="send(item)">{{item.commonname}}</view>
			</view>
			<view class="fz24 c9 tac lh100">{{ isMore? "Loading":"noMore"}}</view>
		</view>
		<!-- 没有搜索结果 -->
		<view v-if="noMore">
			<u-empty text="There is no content" mode="list" margin-top="200"></u-empty>
		</view>

	</view>
</template>

<script>
	import Mixins from '@/static/js/mixins.js';
	export default {
		mixins: [Mixins],
		data() {
			return {
				isLoad: false,
				searchName: "",
				list: [],
				noMore: false,
				param: {},
				pageIndex: 1
			}
		},
		onLoad(option) {
			this.param = option;
			
			if(option.keyword) {
				this.searchName = option.keyword;
				this.getList();
			}
		},
		methods: {
			send(item) {
				uni.$emit('searchClickBack', item);
				uni.navigateBack({
					delta: 1
				})
				// console.log(item);
			},
			getList() {
				if (!this.searchName) {
					this.requestSet.showToast('Please enter search information');
					return;
				};
				this.isLoad = true;
				uni.showLoading({
					mask: true,
					title: 'Loading'
				})
				var datas = {
					name: this.searchName,
					page: this.pageIndex,
					limit: this.$r.pageSize,
				};
				this.requestSet.getData(datas, '/V1.Garden/getName', 'GET').then((res) => {
					if (res.status == 200) {
						if (this.pageIndex == 1) {
							this.list = res.data.list;
						} else {
							this.list = this.list.concat(res.data.list);
						};
					} else {
						this.requestSet.showToast(res.returnstr);
					};
					this.getNextPage(res.data.list);
					this.isLoad = false;
				}).catch((err) => {
					console.log(err)
					this.isLoad = false;
					this.disabled = false;
				});
			}
		}
	}
</script>

<style>
	.p10_30 {
		padding: 10rpx 30rpx;
	}

	.search_box {
		height: 70rpx;
		border-radius: 35rpx;
		overflow: hidden;
		background-color: #f6f7f9;
	}

	.p0_40 {
		padding: 0 40rpx;
	}

	.tag {
		line-height: 54rpx;
		padding: 0 20rpx;
		margin-bottom: 20rpx;
		margin-right: 20rpx;
	}
</style>
