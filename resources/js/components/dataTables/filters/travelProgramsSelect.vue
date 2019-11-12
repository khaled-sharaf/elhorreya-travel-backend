<template>
    <!-- Products type -->
    <div class="box column_active">
        <div class="filter filter_one">
            <div class="header"> {{$t('global.the_travel_program')}} </div>
            <div class="body">
                <div class="wrapper-select-item">
                    <select class="custom-select custom-select-sm" v-model="tableData.travel_program_id" @change="getData()">
                        <option value="">{{$t('global.all')}}</option>
                        <option :value="travelProgram.id" v-for="travelProgram in travelPrograms" :key="travelProgram.id" v-text="travelProgram.name"></option>
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
    "travelPrograms",
    "getData"
  ],
}
</script>

