<template>
    <!-- Created Between -->
    <div class="box column_date_between">
        <div class="filter filter_date">
            <div class="header"> {{$t('datatable.created_between')}} </div>
            <div class="body">
                <span class="input-date from">
                    <date-picker
                        v-model="tableData.from_date"
                        type="datetime"
                        format="YYYY-MM-DD hh:mm:ss"
                        :placeholder="$t('global.from')"
                        lang="en"
                    ></date-picker>
                </span>
                <span class="input-date to">
                    <date-picker
                        v-model="tableData.to_date"
                        type="datetime"
                        format="YYYY-MM-DD hh:mm:ss"
                        :placeholder="$t('global.to')"
                        lang="en"
                    ></date-picker>
                </span>
            </div>
        </div>
        <!-- ./filter-one-->
    </div>
    <!-- ./box-->
</template>





<script>
export default {
    props: [
    "tableData"
  ],
}
</script>

