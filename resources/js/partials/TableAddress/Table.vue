<template>


    <Details 
    :show="showDetails"
    :data="detailsData"
    @visibleChanges="showDetails = $event"
    ></Details>


    <div>
        <DataTable v-model:selection="addressesStore.selected" :value="addressesStore.list" :paginator="true" class="p-datatable-customers" :rows="10"
            dataKey="id" :rowHover="true" v-model:filters="filters" filterDisplay="menu" :loading="addressesStore.loading"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[10,25,50]"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
            :globalFilterFields="['name','zip', 'user.email', 'friendly_name']" responsiveLayout="scroll">
            <template #header>
                <div class="flex justify-content-center align-items-center">
                    <h5 class="m-0">Address book </h5>
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                    </span>
                </div>
            </template>
            <template #empty>
                No addesses found.
            </template>
            <template #loading>
                Loading addresses data. Please wait.
            </template>


            <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>

            

            <Column field="name" header="Name" sortable style="min-width: 14rem">
                <template #body="{data}">
                    {{data.friendly_name || data.name}}
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

            <Column field="details" header="Details" style="min-width: 14rem">
                <template #body="{data}">
                    <Button label="Details" @click="initDetails(data)"></Button>
                </template>
            </Column>

            <Column field="location" header="Location" style="min-width: 14rem">
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

    <Button 
    @click.stop="deleteSelected"
    v-if="addressesStore.selected.length > 0" 
    class="p-button-raised p-button-danger" >
        <span v-if="deleting">Deleting ...</span>
        <span v-else>Delete selected ({{ addressesStore.selected.length }}) one after the other</span>
    </Button>
    <Button 
    @click.stop="deleteSelectedImmediately"
    v-if="addressesStore.selected.length > 0" 
    class="p-button-raised p-button-danger" >
        <span v-if="deleting">Deleting ...</span>
        <span v-else>Delete selected ({{ addressesStore.selected.length }}) immediately</span>
    </Button>

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

import Details from './Details.vue'

export default {
    components: {
        DataTable,
        Column,
        ColumnGroup,
        Row,
        Button,
        InputText,
        Details,
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
                'zip': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
                'user': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
                
            },
            loading: true,

            selected: [],
            deleting: false,

            showDetails:false,
            detailsData:{},
        }
    },
    created() {
        //this.customerService = new CustomerService();
    },
    mounted() {
        
        this.addressesStore.init()        
    },
    methods: {
        deleteSelected() {
            if(this.deleting) return

            this.deleting = true

            this.addressesStore.deleteSelected((success) => {
                this.deleting = false
                if(!success) this.$toast.add({severity:'error', summary:'Error', detail: 'There was a problem deleting addresses'});
            })
        },

        deleteSelectedImmediately() {
            if(this.deleting) return

            this.deleting = true

            this.addressesStore.deleteSelectedImmediately((success) => {
                this.deleting = false
                if(!success) this.$toast.add({severity:'error', summary:'Error', detail: 'There was a problem deleting addresses'});
            })
        },

        initDetails(data) {
            console.log(data)
            this.showDetails = true
            this.detailsData = data
        },
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