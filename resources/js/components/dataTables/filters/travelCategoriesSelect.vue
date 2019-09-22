<template>
    <!-- Products type -->
    <div class="box column_active">
        <div class="filter filter_one">
            <div class="header"> {{$t('global.the_travel_category')}} </div>
            <div class="body">
                <div class="wrapper-select-item">
                    <select class="custom-select custom-select-sm" v-model="tableData.travel_category_id" @change="$emit('getData')">
                        <option value="">{{$t('global.all')}}</option>
                        <option :value="travelCategory.id" v-for="travelCategory in travelCategories" :key="travelCategory.id" v-text="travelCategory.name"></option>
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
    "travelCategories"
  ],
}
</script>

