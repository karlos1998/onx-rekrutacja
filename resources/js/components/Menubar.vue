<template>

    <newAddressDialog 
    :show="showAddressDialog"
    @visibleChanges="showAddressDialog = $event"
    ></newAddressDialog>


    <Menubar :model="items">
        <template #start>
            <!-- <img alt="logo" src="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png" height="40" class="mr-2"> -->
        </template>
        <template #end>
            <!-- <InputText placeholder="Search" type="text" /> -->
        </template>
    </Menubar>
</template>

<script>
import Menubar from 'primevue/menubar';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';

import newAddressDialog from './newAddressDialog.vue'

export default {
    components:{
        Menubar,
        InputText,
        Dialog,
        Button,
        newAddressDialog
    },
    data() {
        return {
            
            showAddressDialog:false,

            items: [
                {
                    label:'File',
                    icon:'pi pi-fw pi-file',
                    items:[
                        {
                            label:'New',
                            icon:'pi pi-fw pi-plus',
                            command: () => {
                                this.showAddressDialog = true
                            },
                            // items:[
                            //     {
                            //         label:'Bookmark',
                            //         icon:'pi pi-fw pi-bookmark'
                            //     },
                            //     {
                            //         label:'Video',
                            //         icon:'pi pi-fw pi-video'
                            //     }
                            // ]
                        },
                        // {
                        //     label:'Delete',
                        //     icon:'pi pi-fw pi-trash'
                        // },
                        // {
                        //     separator:true
                        // },
                        // {
                        //     label:'Export',
                        //     icon:'pi pi-fw pi-external-link'
                        // }
                    ]
                },
                {
                    label:'Logout',
                    icon:'pi pi-fw pi-power-off'
                }
            ]
        }
    },
    
}
</script>