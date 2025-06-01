<template>
	<view>
		<view class="p30">
			<view class="p20 bor10 bgf4">
				<textarea maxlength="-1"  value="" class="fz28 c3" placeholder="Please input your comments or suggesrions.(within 800 words)"
				 v-model="desc" />
				</view>
			<view class="h20"></view>
			<view class="fz26 c9">
				Note:for urgent questions.plese call 188-8888-8888get help in time
			</view>
			<view class="h50"></view>
			<view class="">
				<u-button type="primary" clas="btn h100 " :custom-style="customStyle" :ripple="true" :disabled="disabled" @click="submit">Submit</u-button>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				disabled: false,
				customStyle: {
					height: "80rpx",
					borderRadius: "40rpx",
					backgroundImage: "linear-gradient(to right, #52d0bb, #48d39a)"
				},
				desc:""
			}
		},
		methods: {
			submit() {
				if (this.disabled) return;
				
				if (!this.desc) {
					this.requestSet.showToast('Please input your comments');
					return;
				};
				var datas = {
					body: this.desc,
				};
				this.disabled = true;
				this.requestSet.getData(datas, '/V1.Feedback/save', 'POST').then((res) => {
					if (res.status == 200) {
							this.requestSet.showToast('success');
							setTimeout(() => {
								uni.navigateBack({
									delta: 1
								})
							}, 1000);
					} else {
						this.disabled = false;
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					this.disabled = false;
				});
			},
			
		}
	}
</script>

<style>

</style>
