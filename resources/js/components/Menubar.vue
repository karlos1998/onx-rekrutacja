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

import { useUserStore } from '@/stores/user'

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
            
            user: useUserStore(),

            showAddressDialog:false,

            items: []
        }
    },

    beforeMount() {
        this.items = [
            {
                label:'New address',
                icon:'pi pi-fw pi-plus',
                command: () => {
                    this.showAddressDialog = true
                },
            },
            {
                label: this.user.data.firstname + ' ' + this.user.data.lastname,
                icon:'pi pi-fw pi-user',
                items:[
                    {
                        label:'Logout',
                        icon:'pi pi-fw pi-power-off',
                        command: () => {
                            this.user.logout((success) => {
                                if(success) {
                                    this.$toast.add({severity:'info', summary:'Logout', detail: 'See you', life: 3000});
                                    this.$router.push({ name: 'signin' });
                                } else {
                                    this.$toast.add({severity:'error', summary:'Logout', detail: 'Logout failed', life: 3000});
                                }
                            })
                        },
                    },
                ]
            }
        ]
    }
    
}
</script>