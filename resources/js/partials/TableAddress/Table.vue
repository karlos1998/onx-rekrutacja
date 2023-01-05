<template>
    <div>
        <DataTable :value="addressesStore.list" :paginator="true" class="p-datatable-customers" :rows="10"
            dataKey="id" :rowHover="true" v-model:selection="selectedCustomers" v-model:filters="filters" filterDisplay="menu" :loading="addressesStore.loading"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[10,25,50]"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
            :globalFilterFields="['name','country.name','representative.name','status']" responsiveLayout="scroll">
            <template #header>
                <div class="flex justify-content-center align-items-center">
                    <h5 class="m-0">Customers</h5>
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                    </span>
                </div>
            </template>
            <template #empty>
                No customers found.
            </template>
            <template #loading>
                Loading customers data. Please wait.
            </template>
            <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
            <Column field="name" header="Name" sortable style="min-width: 14rem">
                <template #body="{data}">
                    {{data.name}}
                </template>
                <!-- <template #filter="{filterModel}">
                    <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by name"/>
                </template> -->
            </Column>

            <Column field="zip" header="Zip Code" sortable style="min-width: 14rem">
                <template #body="{data}">
                    {{data.zip}}
                </template>
            </Column>

            <Column field="location" header="Location" sortable style="min-width: 14rem">
                <template #body="{data}">
                    <a target=_blank :href="'https://www.google.com/maps/search/?api=1&query='+data.location_latitude+','+data.location_longitude"><Button click="navigate" role="link" label="Location"></Button></a>
                </template>
            </Column>

            <!-- if the user has permission to view all addresses, he gets an additional column with the owner's name -->
            <Column v-if="hasReadAllPermission" field="user" header="User" sortable style="min-width: 14rem">
                <template #body="{data}">
                    {{data.user.email}}
                </template>
            </Column>
            
            
        </DataTable>
	</div>
</template>



<script>

import {FilterMatchMode,FilterOperator} from 'primevue/api';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';     //optional for column grouping
import Row from 'primevue/row';                     //optional for row

import {useUserStore} from '@/stores/user'
import {useAddressesStore} from '@/stores/addresses'

import Button from 'primevue/button';
import InputText from 'primevue/inputtext';


export default {
    components: {
        DataTable,
        Column,
        ColumnGroup,
        Row,
        Button,
        InputText,
    },

    data() {
        return {
            user: useUserStore(),
            addressesStore: useAddressesStore(),

            customers: null,
            selectedCustomers: null,
            filters: {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
                'name': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
                
            },
            loading: true,
        }
    },
    created() {
        //this.customerService = new CustomerService();
    },
    mounted() {
        
        this.addressesStore.init()
        
    },
    methods: {

    },

    computed: {
        hasReadAllPermission() {
            return this.user.data.permissions.filter( a => a.name == "all-addresses-read").length > 0
        }
    }
}
</script>

<style lang="scss" scoped>
::v-deep(.p-paginator) {
    .p-paginator-current {
        margin-left: auto;
    }
}

::v-deep(.p-progressbar) {
    height: .5rem;
    background-color: #D8DADC;

    .p-progressbar-value {
        background-color: #607D8B;
    }
}

::v-deep(.p-datepicker) {
    min-width: 25rem;

    td {
        font-weight: 400;
    }
}

::v-deep(.p-datatable.p-datatable-customers) {
    .p-datatable-header {
        padding: 1rem;
        text-align: left;
        font-size: 1.5rem;
    }

    .p-paginator {
        padding: 1rem;
    }

    .p-datatable-thead > tr > th {
        text-align: left;
    }

    .p-datatable-tbody > tr > td {
        cursor: auto;
    }

    .p-dropdown-label:not(.p-placeholder) {
        text-transform: uppercase;
    }
}
</style>