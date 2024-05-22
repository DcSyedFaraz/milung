<template>
    <div>
        <div class="container mt-5">
            <div class=" justify-content-start">
                <div class="col-md-12">
                    <h3 class="fw-bold mb-4" style="color: #14245c;">Buyer Entry</h3>
                    <form @submit.prevent="submitForm">
                        <div class=" ">

                            <div class="row">

                                <div class="d-flex col-6  my-2" v-if="!isEditMode">
                                    <div class="col-6">
                                        <p for="name">OTP:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="buyer.otp" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex col-6  my-2">
                                    <div class="col-6">
                                        <p for="name">User ID:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="buyer.userid" required pattern="[a-zA-Z0-9]{1,10}"
                                            class="form-control"
                                            :class="{ 'is-invalid': !userIdPatternValid, 'is-valid': userIdPatternValid }">
                                        <div v-if="!userIdPatternValid" class="invalid-feedback">
                                            User ID must be alphanumeric and between 1 and 10 characters long.
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Status:</p>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-select" v-model="buyer.status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Buyer Name:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="buyer.name" class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Contact person:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="buyer.contact_person"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">

                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Office Phone/Mobile:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="buyer.officePhone"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Email:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="buyer.email" class="form-control"
                                            id="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Address:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="buyer.address" class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Website:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="buyer.website" class="form-control"
                                            id="email">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-group ">
                            <label for="buyerDescription" class="form-label">Buyer Description</label>
                            <textarea class="form-control" id="buyerDescription" v-model="buyer.buyerDescription"
                                rows="3" style="height: 120px; "></textarea>
                        </div>
                        <div class="form-group col-6 my-2">
                            <label class="form-label">Product Group</label>

                            <div class="form-group">
                                <multiselect v-model="buyer.group" :options="productOptions" :multiple="true"
                                    label="group_name" track-by="id">
                                </multiselect>
                            </div>

                        </div>
                        <div class="d-flex gap-2 my-2">
                            <button type="submit" class="btn col-1 btn-milung" style="height: 45px; ">Submit</button>
                            <button type="reset" class="btn btn-warning col-1" style="height: 45px; ">Clear</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 ">

                    <div class="card  ">
                        <div class="card-header pt-3  ">
                            <div class="d-flex justify-content-between align-items-center ">
                                <div class="col-6">
                                    <span class=" mt-2 fw-bold fs-4 " style="color: #14245c;">Order History:</span>
                                </div>
                                <div class="col-4">

                                    <input type="text" class="form-control" placeholder="Search Products..." />
                                </div>
                            </div>
                        </div>

                        <div class="card-body rounded-top">


                            <!-- Table with stripped rows -->
                            <table class="table table-striped  display " id="">
                                <thead style="color: #009de1; " class="">
                                    <tr class="rounded-top-new" style="">
                                        <th>
                                            Order Number
                                        </th>
                                        <th>Order Date</th>
                                        <th>Buyer Name</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Article Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>OrderN01</td>
                                        <td>22-07-23 21</td>
                                        <td>John Smith</td>
                                        <td>2500</td>
                                        <td>
                                            1500
                                        </td>
                                        <td>
                                            ArticleNo1
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>OrderN01</td>
                                        <td>22-07-23 21</td>
                                        <td>John Smith</td>
                                        <td>2500</td>
                                        <td>
                                            1500
                                        </td>
                                        <td>
                                            ArticleNo1
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>OrderN01</td>
                                        <td>22-07-23 21</td>
                                        <td>John Smith</td>
                                        <td>2500</td>
                                        <td>
                                            1500
                                        </td>
                                        <td>
                                            ArticleNo1
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import './index';

export default {
    data() {
        return {
            productOptions: [],
            buyer: {
                name: '',
                userid: '',
                email: '',
                address: '',
                website: '',
                contact_person: '',
                officePhone: '',
                buyerDescription: '',
                group: []
            },
            errors: [],
            isEditMode: false,
            buyerId: null,
        };
    },
    methods: {
        async fetchProductOptions() {
            try {
                const response = await axios.get('/api/product_group_get');
                this.productOptions = response.data;
                console.log(this.productOptions);
            } catch (error) {
                console.error(error);
            }
        },
        async fetchBuyerDetails(buyerId) {
            try {
                const response = await axios.get(`/api/buyers/${buyerId}`);
                const buyer = response.data;
                console.log(buyer);

                this.buyer = {
                    name: buyer.name,
                    userid: buyer.userid,
                    email: buyer.email,
                    status: buyer.status,
                    address: buyer.buyer_profile?.address,
                    website: buyer.buyer_profile?.website,
                    contact_person: buyer.contact_person,
                    officePhone: buyer.buyer_profile?.office_phone,
                    buyerDescription: buyer.buyer_profile?.buyer_description,
                    group: buyer.buyer_profile?.group.map(groupItem => {
                        // Find the option with the same id as groupItem.id
                        const option = this.productOptions.find(option => option.id === groupItem);
                        // console.log(option, this.productOptions, groupItem);
                        return {
                            id: option.id,
                            group_name: option.group_name
                        };
                    })
                };
            } catch (error) {
                console.error(error);
            }
        },
        async submitForm() {
            this.errors = [];
            const requiredFields = ['name', 'userid', 'email', 'address', 'website', 'buyerDescription', 'group'];
            requiredFields.forEach(field => {
                if (!this.buyer[field] || (Array.isArray(this.buyer[field]) && !this.buyer[field].length)) {
                    this.errors.push(`${field.charAt(0).toUpperCase() + field.slice(1)} is required.`);
                }
            });

            if (!this.errors.length) {
                const formData = {
                    ...this.buyer,
                    group: this.buyer.group.map(groupItem => groupItem.id) // Send only IDs
                };

                try {
                    let response;
                    if (this.isEditMode) {
                        response = await axios.post(`/api/buyers/${this.buyerId}`, formData);
                    } else {
                        response = await axios.post('/api/addbuyers', formData);
                    }

                    this.resetForm();

                    if (response.status === 201 || response.status === 200) {
                        toastr.success(response.data.message);
                        this.$router.push({ name: 'Databuyer' });
                    } else {
                        toastr.error('Unexpected response from the server');
                    }
                } catch (error) {
                    console.error(error);
                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors;
                        Object.values(validationErrors).forEach(errorMessage => {
                            toastr.error(errorMessage[0]);
                        });
                    } else {
                        toastr.error('An error occurred while saving the buyer');
                    }
                }
            } else {
                this.errors.forEach(error => {
                    toastr.error(error);
                });
                toastr.options = {
                    'closeButton': true,
                    'timeOut': '3000'
                }
            }
        },
        resetForm() {
            this.buyer = {
                name: '',
                userid: '',
                email: '',
                address: '',
                website: '',
                contact_person: '',
                officePhone: '',
                buyerDescription: '',
                group: []
            };
            this.errors = [];
        }
    },
    async mounted() {
        await this.fetchProductOptions();

        if (this.$route.params.id) {
            this.isEditMode = true;
            this.buyerId = this.$route.params.id;
            await this.fetchBuyerDetails(this.buyerId);
        }
    },
    computed: {
        userIdPatternValid() {
            const pattern = /^[a-zA-Z0-9]{1,10}$/;
            return pattern.test(this.buyer.userid);
        }
    }
};
</script>



<style>
@import url('./style.css');

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #14245c !important;
    color: white;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remov {
    float: right !important;
    margin-left: 5px !important;
    margin-right: -2px !important;
}

.table {
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;

    border-radius: 10px 10px 0 0;
    overflow: hidden;
}
</style>
