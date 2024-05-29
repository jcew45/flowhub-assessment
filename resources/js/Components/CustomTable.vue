<template>
    <div class="custom-table">
        <!-- title wrapper: title, currentpage -->
        <div class="table-title-wrapper">
            <div class="table-title">
                {{ tableTitle }}
            </div>
            <div class="top-pagination">
                <Paginator :rows="10" :totalRecords="120"
                    template="FirstPageLink PrevPageLink JumpToPageInput CurrentPageReport NextPageLink LastPageLink"
                    currentPageReportTemplate=" of {last}"
                >
                </Paginator>
            </div>
        </div>
        <!-- table content -->
        <slot></slot>
        <!-- pagination, pagesize -->
        <div class="bottom-pagination">
            <Paginator :rows="10" :totalRecords="120" :rowsPerPageOptions="[10, 20, 30]"></Paginator>
        </div>

    </div>
</template>

<script setup>
import Paginator from 'primevue/paginator';

const props = defineProps(['tableTitle'])

console.log(props.tableTitle)

</script>

<style lang="scss" scoped>
.custom-table {
    border-radius: 12px;
    background: white;
    margin: 1rem;
    .table-title-wrapper {
        padding: 21px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        .table-title {
            margin-left: 28px;
            font-size: 18px;

        }
    }
    .bottom-pagination {
        padding: 16px 0;
        margin-left: auto;
        width: fit-content;
    }
}
</style>