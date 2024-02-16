<template>
    <div class="w-2/4 mx-auto">
        <div class="flex justify-between my-3">
            <h1 class="font-extrabold text-2xl">Customers</h1>
            <button
                type="button"
                @click="handleAddCustomer"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded me-1"
            >
                Add Customer
            </button>
        </div>
        <table class="border-collapse border border-slate-400 table-auto">
            <thead>
                <tr>
                    <th class="border border-slate-300 p-2">Name</th>
                    <th class="border border-slate-300 p-2">Email</th>
                    <th class="border border-slate-300 p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(customer, i) in customers?.data" :key="i">
                    <td class="border border-slate-300 p-2">
                        {{ customer?.name }}
                    </td>
                    <td class="border border-slate-300 p-2">
                        {{ customer?.email }}
                    </td>
                    <td class="border border-slate-300 p-2">
                        <button
                            type="button"
                            @click="handleDetails(customer)"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded me-1"
                        >
                            Details
                        </button>
                        <button
                            type="button"
                            @click="
                               handleEditCustomer(customer)
                            "
                            class="bg-yellow-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded me-1"
                        >
                            Edit
                        </button>
                        <button
                            type="button"
                            @click="deleteCustomer(customer)"
                            class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <Pagination
            v-if="customersCount > 0"
            class="mt-5"
            :links="customers?.links"
            :paginationObj="paginationObj"
            :data="{}"
        >
        </Pagination>

        <!-- START: Customer Details Modal -->
        <div
            v-if="showDetails"
            class="relative z-10"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            ></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                    >
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <CustomerDetails
                                    :customerDetailObj="customerDetailObj"
                                ></CustomerDetails>
                            </div>
                        </div>
                        <div
                            class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                        >
                            <button
                                @click="showDetails = false"
                                type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Customer Details Modal -->

        <DeleteModal
            v-if="showDeleteModal"
            :deleteObj="deleteObj"
            @cancel-delete="showDeleteModal = false"
        ></DeleteModal>



        <!-- START: Customer Save Modal -->
        <div
            v-if="showSaveModal"
            class="relative z-10"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            ></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                    >
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <SaveCustomer @cancel-save="showSaveModal = false" :errors="errors" :customerData="customerData" :isAdd="isAdd"></SaveCustomer>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Customer Save Modal -->







    </div>
</template>

<script>
import Pagination from "@/js/Components/General/Pagination.vue";
import CustomerDetails from "@/js/Pages/Customer/Components/CustomerDetails.vue";
import DeleteModal from "@/js/Pages/Customer/Components/DeleteModal.vue";
import SaveCustomer from "@/js/Pages/Customer/Components/SaveCustomer.vue";

export default {
    name: "Index",
    props: {
        errors: Object,
        customersList: Object,
    },
    components: {
        Pagination,
        CustomerDetails,
        DeleteModal,
        SaveCustomer,
    },
    data() {
        return {
            customers: {},
            customersCount: 0,
            customerId: null,
            paginationObj: {},
            showDetails: false,
            customerDetailObj: {},
            showDeleteModal: false,
            deleteObj: {},
            showSaveModal: false,
            customerData: {},
            isAdd: true,
        };
    },
    created() {
        const base = this;
        base.customers = JSON.parse(JSON.stringify(base.customersList));
        base.customersCount = base.customersList?.total;
        console.log('sdadas', base.customers);
        base.paginationObj = {
            to: base.customersList?.to,
            from: base.customersList?.from,
            total: base.customersList?.total,
        };
    },
    watch: {
        customersList: {
            handler(newValue, oldValue) {
                const base = this;
                base.customers = JSON.parse(JSON.stringify(newValue));
                base.customersCount = newValue?.total;
                base.paginationObj = {
                    to: newValue?.to,
                    from: newValue?.from,
                    total: newValue?.total,
                };
            },
            deep: true,
        },
    },
    methods: {
        handleDetails(customer) {
            const base = this;
            base.showDetails = true;
            base.customerDetailObj = customer;
        },
        deleteCustomer(customer) {
            const base = this;
            base.showDeleteModal = true;
            base.deleteObj = {
                title: "Delete Customer",
                msg: `Are you sure you want to delete the customer ${customer?.name}`,
                customerId: customer?.id,
            };
        },
        handleAddCustomer() {
            const base = this;
            base.showSaveModal = true;
            base.isAdd = true;
        },
        handleEditCustomer(customer){
            const base = this;
            base.showSaveModal = true;
            base.customerData = customer;
            base.isAdd = false;
        }
    },
};
</script>
