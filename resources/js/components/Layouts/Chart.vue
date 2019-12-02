<template>
    <div>

        <chart :options="chartOptionsBar"></chart>

    </div>
</template>

<script>
export default {
    data() {
        return {
            chartOptionsBar: {
                xAxis: {
                    data: ['Male', 'Female']
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                    type: 'bar',
                    data: [10, 13]
                    }
                ],
                 title: {
                    text: 'Students by Gender'
                }
            },
        }
       
    }
}
</script>

<style scoped>

</style>