<template>
    <!-- Products type -->
    <div class="box column_active">
        <div class="filter filter_one">
            <div class="header"> {{$t('global.the_hotel')}} </div>
            <div class="body">
                <div class="wrapper-select-item">
                    <select class="custom-select custom-select-sm" v-model="tableData.hotel_id" @change="$emit('getData')">
                        <option value="">{{$t('global.all')}}</option>
                        <option :value="hotel.id" v-for="hotel in hotels" :key="hotel.id" v-text="hotel.name"></option>
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
    "hotels"
  ],
}
</script>

