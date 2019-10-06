<template>
    <!-- Products type -->
    <div class="box column_active">
        <div class="filter filter_one">
            <div class="header"> {{$t('global.the_travel')}} </div>
            <div class="body">
                <div class="wrapper-select-item">
                    <select class="custom-select custom-select-sm" v-model="tableData.travel_id" @change="$emit('getData')">
                        <option value="">{{$t('global.all')}}</option>
                        <option :value="travel.id" v-for="travel in travels" :key="travel.id" v-text="travel.name"></option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- ./box-->
</template>





<script>
export default {
    props: [
    "tableData",
    "travels"
  ],
}
</script>

