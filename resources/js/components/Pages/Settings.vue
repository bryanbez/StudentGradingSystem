<template>
    <div class="container">
        <br />
        <h3>Settings</h3>
        <br />

            <hr />
        <div class="row">
            <h4> Critea </h4>
            
            <div class="col-md-12 col-lg-12">
                <button class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addCritea"> Add Critea </button>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Critea Name</th>
                        <th>Percentage</th>
                        <th>Default Grade</th>
                        <th colspan="2">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="getCriteaRecords in fetchCriteaInfos" :key="getCriteaRecords.id">
                        <td scope="row">{{ getCriteaRecords.critea }}</td>
                        <td> {{ getCriteaRecords.percentage | putPercentage }} </td>
                        <td> {{ getCriteaRecords.defaultGrade }}</td>
                        <td><button class="btn btn-primary" @click="editCritea(getCriteaRecords.id)" data-toggle="modal" data-target="#updateCritea">Edit</button></td>
                        <td><button class="btn btn-danger" @click="deleteCritea(getCriteaRecords.id)">Delete</button></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td><b>Total Percentage: </b></td>
                        <td colspan="3"><b>{{ totalPercentage | putPercentage }}</b></td>
                    </tr>
                </tfoot>
            </table>

             <div class="modal fade" id="addCritea" tab-index="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4> Add Critea </h4>
                        </div>
                        <div class="modal-body">
                            <AddCritea @refreshList="reloadList"></AddCritea>
                        </div>
                        <div class="modal-footer">
                              <button class="btn btn-danger" data-dismiss="modal"> Close </button>
                        </div>
                    </div>
                </div>
            </div>

             <div class="modal fade" id="updateCritea" tab-index="-1" role="dialog" aria-hidden="true" v-if="showModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4> Update Critea </h4>
                        </div>
                        <div class="modal-body">
                            <EditCritea :criteaID="getCriteaId" @refreshList="reloadList"></EditCritea>
                        </div>
                        <div class="modal-footer">
                              <button class="btn btn-danger" data-dismiss="modal" @click="resetToEditData"> Close </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>

import AddCritea from '../Layouts/Settings/addCriteaForm'
import EditCritea from '../Layouts/Settings/EditCriteaForm'

export default {
    components: {
        AddCritea,
        EditCritea
    },
    data() {
        return {
            fetchCriteaInfos: [],
            totalPercentage: [],
            getCriteaId: '',
            showModal: false
        }
    },
    created() {
       this.refreshList()
    },
    methods: {
        refreshList(status) {
             axios.get(`http://localhost:8000/api/managecritea`).then(
                response => {
                    console.log(response);
                    this.fetchCriteaInfos = response.data.criteasRecord;
                    this.totalPercentage = response.data.totalPercentage[0].total_percentage;
                   
                }
            )
        },
        reloadList(value) {
            if(value == 200) {
                this.refreshList()
            }
            else {
                // Stay
            }
        },
        editCritea(critea_id) {

            this.showModal = true;
            this.getCriteaId = critea_id;
  
        },
        deleteCritea(critea_id) {
            if(confirm('Are you sure to delete this critea?')) {
                axios.delete(`http://localhost:8000/api/managecritea/${critea_id}`).then(
                    response => {
                        alert(response.data.original)
                        this.refreshList()
                    })
            }
        },
        resetToEditData() {
            this.showModal = false;
        }
    },
    filters: {
        putPercentage(value) {
            return value + '%';
        }
    }

}
</script>

<style scoped>

</style>