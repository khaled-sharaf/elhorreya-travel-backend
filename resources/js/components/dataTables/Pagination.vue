<template>
  <div class="row">
    <div class="col-sm-12 col-md-5">
      <div class="dataTables_info">
        {{ $t('datatable.showing') }}
        <span class="from">{{ pagination.from }}</span> {{ $t('datatable.to') }}
        <span class="to">{{ pagination.to }}</span> {{ $t('datatable.of') }}
        <span class="total">{{ pagination.total }}</span> {{ $t('datatable.entries') }}
      </div>
    </div>

    <div class="col-sm-12 col-md-7">
      <div class="dataTables_paginate">
        <paginate
            v-if="pagination.path != ''"
            v-model="pagination.currentPage"
            :page-count="Math.ceil(pagination.total / pagination.perPage)"
            :click-handler="gotopage"
            :prev-text="`<i class='fas fa-arrow-right'></i>`"
            :next-text="`<i class='fas fa-arrow-left'></i>`"
            :container-class="'pagination'"
            :page-class="'page-item'"
            :next-class="'next-item'"
            :prev-class="'prev-item'"
            :break-view-class="'break-view-class'"
            :hide-prev-next="true"
        >
        </paginate>

      </div>
    </div>
  </div>
</template>


<script>

export default {
    props: ['pagination', 'getData'],
    methods: {
        gotopage(numPage) {
            this.getData(this.pagination.path + '?page=' + numPage)
        }
    },
}
</script>

