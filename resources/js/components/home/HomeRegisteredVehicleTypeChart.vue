<template>
    <canvas ref="myChart"></canvas>
</template>

<script>
export default {
    async mounted() {
        var res = await axios.get(
            "/backend/chart/registered-vehicle-type"
        );
        var ctx = this.$refs.myChart.getContext("2d");
        const config = {
            type: "bar",
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: "right"
                    },
                    title: {
                        display: true,
                        text: res.data.datasets[0].label
                    }
                }
            },
            data: res.data
        };

        var myChart = new Chart(ctx, config);
    }
};
</script>

<style></style>
