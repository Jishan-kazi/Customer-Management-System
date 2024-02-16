<template>
    <form>
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h1 class="font-extrabold text-2xl">Save Customer</h1>
                <h2 class="text-base font-semibold leading-7 text-gray-900">
                    Personal Information
                </h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    Use a permanent address where you can receive mail.
                </p>

                <div
                    class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                >
                    <div class="sm:col-span-3">
                        <label
                            for="first-name"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Name</label
                        >
                        <div class="mt-2">
                            <input
                                v-model="data.name"
                                type="text"
                                name="first-name"
                                id="first-name"
                                autocomplete="given-name"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            />
                        </div>
                        <div class="text-red-500" v-if="err?.name">
                            {{ err?.name }}
                        </div>
                        <div class="text-red-500" v-if="errors?.name">
                            {{ errors?.name }}
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label
                            for="email"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Email address</label
                        >
                        <div class="mt-2">
                            <input
                                v-model="data.email"
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            />
                        </div>
                        <div class="text-red-500" v-if="err?.email">
                            {{ err?.email }}
                        </div>
                        <div class="text-red-500" v-if="errors?.email">
                            {{ errors?.email }}
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <label
                            for="first-name"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Phone</label
                        >
                        <div class="mt-2">
                            <input
                                v-model="data.phone"
                                type="number"
                                name="first-name"
                                id="first-name"
                                autocomplete="given-name"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            />
                        </div>
                        <div class="text-red-500" v-if="err?.phone">
                            {{ err?.phone }}
                        </div>
                        <div class="text-red-500" v-if="errors?.phone">
                            {{ errors?.phone }}
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label
                            for="about"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Address</label
                        >
                        <div class="mt-2">
                            <textarea
                                v-model="data.address"
                                id="about"
                                name="about"
                                rows="3"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            ></textarea>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            Write your permanent address.
                        </p>
                        <div class="text-red-500" v-if="err?.address">
                            {{ err?.address }}
                        </div>
                        <div class="text-red-500" v-if="errors?.address">
                            {{ errors?.address }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-red-500" v-if="errors?.message">
            {{ errors?.message }}
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button
                @click="$emit('cancelSave')"
                type="button"
                class="text-sm font-semibold leading-6 text-gray-900"
            >
                Cancel
            </button>
            <button
                @click="save"
                type="button"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Save
            </button>
        </div>
    </form>
</template>

<script>
import Swal from "sweetalert2";

export default {
    props: {
        errors: Object,
        customerData: Object,
        isAdd: Boolean,
    },
    data() {
        return {
            data: this.isAdd ? {} : this.customerData,
            err: {
                name: '',
                email: '',
                phone: '',
                address: ''
            }
        };
    },
    methods: {
        checkForm(e) {
            const base = this;
            let validationPassed = true;
            base.err = {
                name: '',
                email: '',
                phone: '',
                address: ''
            };
            if (!base.data?.name) {
                base.err.name = "Name is required";
                validationPassed = false;
            }
            if (!base.data?.email) {
                base.err.email = "Email is required";
                validationPassed = false;
            } else if (!base.validEmail(base.data?.email)) {
                base.err.email = "Email is invalid";
                validationPassed = false;
            }
            if (!base.data?.phone) {
                base.err.phone = "Phone is required";
                validationPassed = false;
            }
            if (!base.data?.address) {
                base.err.address = "Address is required";
                validationPassed = false;
            }

            return validationPassed;
        },
        validEmail(email) {
            var re =
                /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
        save() {
            const base = this;
            if(base.checkForm()){
                let url = route("customer.create");
                if (!base.isAdd) {
                    url = route("customer.update", {
                        customerId: base.customerData?.id,
                    });
                }
                base.$inertia.post(url, base.data, {
                    preserveState: true,
                    preserveScroll: false,
                    onSuccess: () => {
                        if (base.$page?.props?.flash?.message) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: base.$page?.props?.flash?.message,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        }
    
                        base.$inertia.get(route("customer.list"));
                    },
                });
            }
        },
    },
};
</script>
