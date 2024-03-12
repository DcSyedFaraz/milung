<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-milung fw-bold text-center">MiLung Trade Limited</h1>
                <p class="text-center text-milung fw-bold my-3">
                    Unit 1704-05, 17/F. Hang Seng North Point Building,<br>
                    341 North Point, Hong Kong. <br>
                    Tel: 852 2540 2488
                </p>
            </div>
            <div class="col-12">
                <div class="row mx-6 mt-4">
                    <div class="col mx-1 border rounded-3 rounded bg-milung">

                        <div class="text-center p-3">
                            <p class="fw-bold">Invoice No: <br> 12345678</p>
                        </div>

                    </div>
                    <div class="col mx-1 border rounded-3 rounded bg-blue">

                        <div class="text-center p-3">
                            <p class="fw-bold">Cust Ref. (ATC): <br> 12345678</p>
                        </div>
                    </div>
                    <div class="col mx-1 border rounded-3 rounded bg-warning">

                        <div class="text-center p-3">
                            <p class="fw-bold">Date: <br> 12345678</p>
                        </div>
                    </div>
                    <div class="col mx-1 border rounded-3 rounded bg-orange">

                        <div class="text-center p-3">
                            <p class="fw-bold">Prepred By: <br> 12345678</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-5">
                <div class="row">

                    <div class="col-6">
                        <div class="d-flex col-11 my-2">
                            <div class="">
                                <label class="form-label text-milung fw-bold text-uppercase fs-5">Shipper:</label>
                                <textarea v-model="info.shipper" class="form-control" cols="58" rows="6"></textarea>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="">
                                <label class="form-label text-milung fw-bold text-uppercase fs-5">consignee:</label>
                                <textarea v-model="info.consignee" class="form-control" cols="58" rows="6"></textarea>
                            </div>
                        </div>
                        <div class=" col-11 my-2">
                            <div class="">
                                <label class="form-label text-milung fw-bold text-uppercase fs-5">notify party:</label>
                                <input type="text" v-model="info.party" class="form-control ">
                            </div>
                        </div>

                    </div>
                    <div class="col-6">

                        <div class="d-flex col-11 my-2">
                            <div class="">
                                <label class="form-label text-milung fw-bold text-uppercase fs-5">carton mark:</label>
                                <textarea v-model="info.carton" class="form-control" cols="58" rows="6"></textarea>
                            </div>
                        </div>
                        <div class=" col-11 my-4">
                            <div class="">
                                <label class="form-label text-milung fw-bold text-uppercase fs-5">port of
                                    loading:</label>
                                <input type="text" v-model="info.loading" class="form-control ">
                            </div>
                        </div>
                        <div class=" col-11 my-3">
                            <div class="">
                                <label class="form-label text-milung fw-bold text-uppercase fs-5">final
                                    destination:</label>
                                <input type="text" v-model="info.destination" class="form-control ">
                            </div>
                        </div>
                        <div class=" col-11 my-2">
                            <div class="">
                                <label class="form-label text-milung fw-bold text-uppercase fs-5">payment:</label>
                                <input type="text" v-model="info.payment" class="form-control ">
                            </div>
                        </div>
                        <div class=" col-11 my-4 d-flex justify-content-end">
                            <div class="">
                                <button class="btn btn-success px-5">Save</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-4" style="background-color: #14245c;">
        <div class="row justify-content-between">

            <div class="col-3 my-2">
                <div class="d-flex">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto fs-7 text-white"><i class="bi bi-box text-warning"></i> SO#:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="info.so_no" class="form-control ">
                    </div>
                </div>
            </div>

            <div class="col-3 my-2">
                <div class="d-flex">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto fs-7 text-white"><i class="bi bi-truck text-warning"></i>
                            Courier:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="info.courier" class="form-control ">
                    </div>
                </div>
            </div>

            <div class="col-3 my-2">
                <div class="d-flex">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto fs-7 text-white"><i
                                class="bi bi-journal-check text-warning"></i> Tracking#:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="info.tracking" class="form-control ">
                    </div>
                </div>
            </div>

            <div class="col-3 my-auto">
                <button class="btn btn-warning mx-3 my-auto px-5 fw-bold" type="reset">Save</button>
            </div>

        </div>
    </div>
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header  ">
                        <div class="">

                        </div>
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span>
                                <span class=" fw-bold fs-4 text-uppercase" style="color: #14245c;">III Packing
                                    List:</span>
                            </span>

                            <div class="col-4 d-flex">
                                <div class="col-12 d-flex">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: #41b400;"
                                                    class="bx bx-filter-alt fw-bold fs-4"></i></span>
                                            <input type="text" name="search" class="form-control " v-model="searchQuery"
                                                ref="search" placeholder="Write here to filter..." />
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card-body rounded-top table-responsive">

                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover  ">
                            <thead style="color: #009de1; " class="text-center fs-7 ">
                                <tr style="">
                                    <th class="text-nowrap"> Carton No. </th>
                                    <th class="text-nowrap">Order Number</th>
                                    <th class="text-nowrap">Description</th>
                                    <th class="text-nowrap">QTY</th>
                                    <th class="text-nowrap">Ctn</th>
                                    <th class="text-nowrap">Total Qty</th>
                                    <th class="text-nowrap">N.W. (KGS)</th>
                                    <th class="text-nowrap">Total</th>
                                    <th class="text-nowrap">G.W. (KGS)</th>
                                    <th class="text-nowrap">Total</th>


                                    <th class="text-nowrap text-milung">L(CM)</th>
                                    <th class="text-nowrap"><span>Carton Measurement</span> <br>
                                        <span class="text-milung">W(CM)</span>
                                    </th>
                                    <th class="text-nowrap text-milung">H(CM)</th>
                                    <th class="text-nowrap text-milung">CBM</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td colspan="17">
                                        <p class="text-center">No data to display.</p>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            info: {},
            searchQuery: '',
        }
    }
}
</script>

<style scoped>
.mx-6 {
    margin-right: 11rem !important;
    margin-left: 11rem !important;
}

.bg-blue {
    background-color: #009de1 !important;
    border-color: #009de1 !important;
    color: white;
}

.bg-milung {
    background-color: #14245c !important;
    border-color: #14245c !important;
    color: white;
}

.bg-orange {
    background-color: #f67b00 !important;
    border-color: #f67b00 !important;
    color: white;
}
</style>
