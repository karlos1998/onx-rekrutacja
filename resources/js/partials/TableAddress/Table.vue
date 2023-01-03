<template>
    <div>
        <DataTable :value="customers" :paginator="true" class="p-datatable-customers" :rows="10"
            dataKey="id" :rowHover="true" v-model:selection="selectedCustomers" v-model:filters="filters" filterDisplay="menu" :loading="loading"
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
            <Column field="country.name" header="Country" sortable filterMatchMode="contains" style="min-width: 14rem">
                <template #body="{data}">
                    <img src="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png" :class="'flag flag-' + data.country.code" width="30" />
                    <span class="image-text">{{data.country.name}}</span>
                </template>
                <!-- <template #filter="{filterModel}">
                    <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by country"/>
                </template> -->
            </Column>
            <Column header="Agent" sortable filterField="representative" sortField="representative.name" :showFilterMatchModes="false" :filterMenuStyle="{'width':'14rem'}" style="min-width: 14rem">
                <template #body="{data}">
                    <img :alt="data.representative.name" src="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png" width="32" style="vertical-align: middle" />
                    <span class="image-text">{{data.representative.name}}</span>
                </template>
                <!-- <template #filter="{filterModel}">
                    <div class="mb-3 font-bold">Agent Picker</div>
                    <MultiSelect v-model="filterModel.value" :options="representatives" optionLabel="name" placeholder="Any" class="p-column-filter">
                        <template #option="slotProps">
                            <div class="p-multiselect-representative-option">
                                <img :alt="slotProps.option.name" src="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png" width="32" style="vertical-align: middle" />
                                <span class="image-text">{{slotProps.option.name}}</span>
                            </div>
                        </template>
                    </MultiSelect>
                </template> -->
            </Column>
            <Column field="date" header="Date" sortable dataType="date" style="min-width: 8rem">
                <template #body="{data}">
                    {{formatDate(data.date)}}
                </template>
                <!-- <template #filter="{filterModel}">
                    <Calendar v-model="filterModel.value" dateFormat="mm/dd/yy" placeholder="mm/dd/yyyy" />
                </template> -->
            </Column>
            <Column field="balance" header="Balance" sortable dataType="numeric" style="min-width: 8rem">
                <template #body="{data}">
                    {{formatCurrency(data.balance)}}
                </template>
                <!-- <template #filter="{filterModel}">
                    <InputNumber v-model="filterModel.value" mode="currency" currency="USD" locale="en-US" />
                </template> -->
            </Column>
            <Column field="status" header="Status" sortable :filterMenuStyle="{'width':'14rem'}" style="min-width: 10rem">
                <template #body="{data}">
                    <span :class="'customer-badge status-' + data.status">{{data.status}}</span>
                </template>
                <!-- <template #filter="{filterModel}">
                    <Dropdown v-model="filterModel.value" :options="statuses" placeholder="Any" class="p-column-filter" :showClear="true">
                        <template #value="slotProps">
                            <span :class="'customer-badge status-' + slotProps.value">{{slotProps.value}}</span>
                        </template>
                        <template #option="slotProps">
                            <span :class="'customer-badge status-' + slotProps.option">{{slotProps.option}}</span>
                        </template>
                    </Dropdown>
                </template> -->
            </Column>
            <Column field="activity" header="Activity" sortable :showFilterMatchModes="false" style="min-width: 10rem">
                <template #body="{data}">
                    <ProgressBar :value="data.activity" :showValue="false" />
                </template>
                <!-- <template #filter="{filterModel}">
                    <Slider v-model="filterModel.value" range class="m-3"></Slider>
                    <div class="flex align-items-center justify-content-between px-2">
                        <span>{{filterModel.value ? filterModel.value[0] : 0}}</span>
                        <span>{{filterModel.value ? filterModel.value[1] : 100}}</span>
                    </div>
                </template> -->
            </Column>
            <Column headerStyle="width: 4rem; text-align: center" bodyStyle="text-align: center; overflow: visible">
                <template #body>
                    <Button type="button" icon="pi pi-cog"></Button>
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


export default {
    components: {
        DataTable,
        Column,
        ColumnGroup,
        Row,
    },

    data() {
        return {
            customers: null,
            selectedCustomers: null,
            filters: {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
                'name': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
                'country.name': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
                'representative': {value: null, matchMode: FilterMatchMode.IN},
                'date': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.DATE_IS}]},
                'balance': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.EQUALS}]},
                'status': {operator: FilterOperator.OR, constraints: [{value: null, matchMode: FilterMatchMode.EQUALS}]},
                'activity': {value: null, matchMode: FilterMatchMode.BETWEEN},
                'verified': {value: null, matchMode: FilterMatchMode.EQUALS}
            },
            loading: true,
            representatives: [
                {name: "Amy Elsner", image: 'amyelsner.png'},
                {name: "Anna Fali", image: 'annafali.png'},
                {name: "Asiya Javayant", image: 'asiyajavayant.png'},
                {name: "Bernardo Dominic", image: 'bernardodominic.png'},
                {name: "Elwin Sharvill", image: 'elwinsharvill.png'},
                {name: "Ioni Bowcher", image: 'ionibowcher.png'},
                {name: "Ivan Magalhaes",image: 'ivanmagalhaes.png'},
                {name: "Onyama Limba", image: 'onyamalimba.png'},
                {name: "Stephen Shaw", image: 'stephenshaw.png'},
                {name: "XuXue Feng", image: 'xuxuefeng.png'}
            ],
            statuses: [
                'unqualified', 'qualified', 'new', 'negotiation', 'renewal', 'proposal'
            ]
        }
    },
    created() {
        //this.customerService = new CustomerService();
    },
    mounted() {
        
        setTimeout(() => {
            this.customers = [
                {
                    "id":1000,
                    "name":"James Butt",
                    "country":{
                        "name":"Algeria",
                        "code":"dz"
                    },
                    "company":"Benton, John B Jr",
                    "date":"2015-09-13",
                    "status":"unqualified",
                    "verified":true,
                    "activity":17,
                    "representative":{
                        "name":"Ioni Bowcher",
                        "image":"ionibowcher.png"
                    },
                    "balance":70663
                },
                {
                    "id":1001,
                    "name":"Josephine Darakjy",
                    "country":{
                        "name":"Egypt",
                        "code":"eg"
                    },
                    "company":"Chanay, Jeffrey A Esq",
                    "date":"2019-02-09",
                    "status":"proposal",
                    "verified":true,
                    "activity":0,
                    "representative":{
                        "name":"Amy Elsner",
                        "image":"amyelsner.png"
                    },
                    "balance":82429
                },
                {
                    "id":1002,
                    "name":"Art Venere",
                    "country":{
                        "name":"Panama",
                        "code":"pa"
                    },
                    "company":"Chemel, James L Cpa",
                    "date":"2017-05-13",
                    "status":"qualified",
                    "verified":false,
                    "activity":63,
                    "representative":{
                        "name":"Asiya Javayant",
                        "image":"asiyajavayant.png"
                    },
                    "balance":28334
                },
                {
                    "id":1003,
                    "name":"Lenna Paprocki",
                    "country":{
                        "name":"Slovenia",
                        "code":"si"
                    },
                    "company":"Feltz Printing Service",
                    "date":"2020-09-15",
                    "status":"new",
                    "verified":false,
                    "activity":37,
                    "representative":{
                        "name":"Xuxue Feng",
                        "image":"xuxuefeng.png"
                    },
                    "balance":88521
                },
                {
                    "id":1004,
                    "name":"Donette Foller",
                    "country":{
                        "name":"South Africa",
                        "code":"za"
                    },
                    "company":"Printing Dimensions",
                    "date":"2016-05-20",
                    "status":"proposal",
                    "verified":true,
                    "activity":33,
                    "representative":{
                        "name":"Asiya Javayant",
                        "image":"asiyajavayant.png"
                    },
                    "balance":93905
                },
                {
                    "id":1005,
                    "name":"Simona Morasca",
                    "country":{
                        "name":"Egypt",
                        "code":"eg"
                    },
                    "company":"Chapman, Ross E Esq",
                    "date":"2018-02-16",
                    "status":"qualified",
                    "verified":false,
                    "activity":68,
                    "representative":{
                        "name":"Ivan Magalhaes",
                        "image":"ivanmagalhaes.png"
                    },
                    "balance":50041
                },
                {
                    "id":1006,
                    "name":"Mitsue Tollner",
                    "country":{
                        "name":"Paraguay",
                        "code":"py"
                    },
                    "company":"Morlong Associates",
                    "date":"2018-02-19",
                    "status":"renewal",
                    "verified":true,
                    "activity":54,
                    "representative":{
                        "name":"Ivan Magalhaes",
                        "image":"ivanmagalhaes.png"
                    },
                    "balance":58706
                },
                {
                    "id":1007,
                    "name":"Leota Dilliard",
                    "country":{
                        "name":"Serbia",
                        "code":"rs"
                    },
                    "company":"Commercial Press",
                    "date":"2019-08-13",
                    "status":"renewal",
                    "verified":true,
                    "activity":69,
                    "representative":{
                        "name":"Onyama Limba",
                        "image":"onyamalimba.png"
                    },
                    "balance":26640
                },
                {
                    "id":1008,
                    "name":"Sage Wieser",
                    "country":{
                        "name":"Egypt",
                        "code":"eg"
                    },
                    "company":"Truhlar And Truhlar Attys",
                    "date":"2018-11-21",
                    "status":"unqualified",
                    "verified":true,
                    "activity":76,
                    "representative":{
                        "name":"Ivan Magalhaes",
                        "image":"ivanmagalhaes.png"
                    },
                    "balance":65369
                },
                {
                    "id":1009,
                    "name":"Kris Marrier",
                    "country":{
                        "name":"Mexico",
                        "code":"mx"
                    },
                    "company":"King, Christopher A Esq",
                    "date":"2015-07-07",
                    "status":"proposal",
                    "verified":false,
                    "activity":3,
                    "representative":{
                        "name":"Onyama Limba",
                        "image":"onyamalimba.png"
                    },
                    "balance":63451
                }
            ];
            this.customers.forEach(customer => customer.date = new Date(customer.date));
            this.loading = false;
        }, 3000)
    },
    methods: {
        formatDate(value) {
            return value.toLocaleDateString('en-US', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            });
        },
        formatCurrency(value) {
            return value.toLocaleString('en-US', {style: 'currency', currency: 'USD'});
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