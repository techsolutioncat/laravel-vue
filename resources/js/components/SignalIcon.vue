<template>
    <div>
        <div class="block font-12 p0404" :class="getSignalClass(signal)">{{getSignalText(signal)}}</div>
    </div>
</template>

<script>
    export default {
        name: "SignalIcon",
        props: {
            signal: null,
            icon: null,
            custom: null,
        },
        methods: {
            getSignalText: function (signal) {
                if (signal == 1) {
                    return "非常ブザー"
                } else if (signal == 2) {
                    return "緊急通報"
                } else if (signal == 3) {
                    return "バッテリー低下"
                } else if (signal == 4) {
                    return "電源OFF"
                } else if (signal == 5) {
                    return "電源ON"
                } else if (signal == 6) {
                    return "電話着信"
                } else if (signal == 7) {
                    return "位置問い合わせ"
                } else if (signal == 0) {
                    return "電話番号の設定"
                } else if (signal == 8) {
                  return "位置問い合わせ" //"連続測位"
                } else if (signal == 9) {
                  return "再起動"
                } else if (signal == 11) {
                  return "非常ブザー停止"  
                } else if (signal == 18){
                  return "連続測位停止"
                } else if (signal == 10) {
                  return "バッテリー残量"
                } else if (signal == 100) {
                  return "通信エラー"
                } else if (signal == 101) {
                  return "通信復旧"
                }
            },
            getSignalClass: function (signal) {

                if (signal == 1) {
                    return "buzzer_color " + this.custom;
                } else if (signal == 2) {
                    return "report_color " + this.custom;
                } else if (signal == 6) {
                    return "incoming_color " + this.custom
                } else {
                    return "else_color " + this.custom;
                }
            }
        }
    }
</script>

<style scoped>

</style>
