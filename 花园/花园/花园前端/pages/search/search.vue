<template>
	<view>
		<u-navbar>
			<view class="search_box mr20 flex_1">
				<view class="flex itc p0_40 h70">
					<view class="iconsousuo fz40 c9 mr20"></view>
					<input maxlength="-1"  type="text" class="w100 fz32 c3 flex_1" placeholder="Please enter the content" v-model="keyWord" @confirm="search">
				</view>
			</view>
			<view slot="right">
				<view class="ca fz28 pr20" @click="search">search</view>
			</view>
		</u-navbar>
		<!--  -->
		<view class="p30">
			<view class="flex itc mb40">
				<view class="fz32 c3 fw9  flex_1">Hot search</view>
				<view class="iconshanchu" @click="clearFn" v-show="list.length"></view>
			</view>
			<view class="flex flex_warp">
				<view class="tag fz24 c6 bor5 bgf4" v-for="item in list" @click="toInfo(item)">{{item}}</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				param: "",
				list: [],
				keyWord: ""
			}
		},
		onLoad(option) {
			this.param = option;
			this.list = uni.getStorageSync(this.param.from) || [];
		},
		methods: {
			clearFn() {
				uni.showModal({
					title: 'Tips',
					content: 'Are you sure to clear history search',
					confirmText: "Sure",
					cancelText: "cancel",
					success: (res) => {
						if (res.confirm) {
							this.list = [];
							uni.setStorageSync(this.param.from, this.list);
						}
					}
				});
			},
			toInfo(item) {
				this.setList(item);
				uni.navigateTo({
					url: '/pages/search/list?keyWord=' + item + '&type=' + this.param.from
				})
			},
			search() {
				if (this.keyWord) {
					this.setList(this.keyWord);
					uni.navigateTo({
						url: '/pages/search/list?keyWord=' + this.keyWord + '&type=' + this.param.from
					})
				}
			},
			setList(name) {
				var _index = this.list.indexOf(name);
				if (_index > -1) {
					this.list.splice(_index, 1);
				};
				this.list.unshift(name);
				uni.setStorageSync(this.param.from, this.list);
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
