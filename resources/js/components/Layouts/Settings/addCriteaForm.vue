<template>
    <div class="container">
            <form @submit.prevent="addCritea">
                <div class="alert alert-info" v-if="statusOfUpdate === 200">
                    {{ insertMsg }}
                </div>
            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                <label for="">Critea Name</label>
                <input class="form-control" type="text" v-model="criteaInfo.criteaName" />
                <span v-if="insertMsg.criteaName" class="error"> {{ insertMsg.criteaName | trimCharacters }}</span>   
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                <label for="">Percentage</label>
                <input class="form-control" type="text" v-model="criteaInfo.criteaPercentage" />
                <span v-if="insertMsg.criteaPercentage" class="error"> {{ insertMsg.criteaPercentage | trimCharacters }}</span> 
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                <label for="">Default Critea Grade</label>
                <input class="form-control" type="text" v-model="criteaInfo.defaultCriteaGrade" />
                <span v-if="insertMsg.defaultCriteaGrade" class="error"> {{ insertMsg.defaultCriteaGrade | trimCharacters }}</span> 
            </div>

            <div class="col-md-12 col-lg-12 mt-5">
                <button type="submit" class="btn btn-primary" @click="clearNotification">Add Critea</button>
            </div>
        </form>
    </div>

</template>

<script>
export default {
    data() {
        return {
            criteaInfo: {
                criteaName: '',
                criteaPercentage: '',
                defaultCriteaGrade: '',
            },
            statusOfUpdate: '',
            insertMsg: ''
        }
    },
    methods: {
        addCritea() {
            axios.post(`http://localhost:8000/api/managecritea`, this.criteaInfo).then(
                response => {
                    console.log(response);
                    this.statusOfUpdate = response.status;
                    this.insertMsg = response.data;
                    this.refreshList(response.status);
                    this.clearTextboxes();
            }).catch(error => {
                 this.statusOfUpdate = error.response.status;
                 this.insertMsg = error.response.data.errors;
              
            });
        },
        clearNotification() {
            this.statusOfUpdate = '';
            this.insertMsg = '';
        },
        clearTextboxes() {
            this.criteaInfo.criteaName = '';
            this.criteaInfo.criteaPercentage = '';
            this.criteaInfo.defaultCriteaGrade = '';
        },
        refreshList(status) {
            this.$emit('refreshList', status);
        }
    },
    filters: {
        trimCharacters: function(value) {
            return value.toString();
        }
    }

}
</script>

<style scoped>
.error {
    color:red;
}
</style>