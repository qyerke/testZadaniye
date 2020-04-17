<template>
    <div class="container">
        <nav class="navbar navbar-light bg-light">
    <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" v-model="search" >
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary my-2 my-sm-0" data-toggle="modal" data-target="#exampleModal">
        Filter
        </button>
    </form>
    </nav>
          <div class="row justify-content-center">
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Deadline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="todo in filteredList"  :key="todo.id">
                        <th scope="row">{{todo.id}}</th>
                        <td>{{todo.title}}</td>
                        <td>{{todo.deadline}}</td>
                        </tr>
                    </tbody>
                    </table>
            </div>

        <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                <label for="title">Название</label>
                <input type="text" class="form-control" id="title" v-model="filter.title">
            </div>

            <div class="form-group">
            <multiselect v-model="filter.selected" :multiple="true" :options="options"></multiselect>
            </div>

            <div class="form-group">
            <label for="">Статус</label>
            <multiselect v-model="filter.statusSelected" :multiple="true" :options="statusses" name="statusses"></multiselect>
            </div>

            <div class="form-group">
            <label for="example-date-input" class="col-2 col-form-label">Date</label>
            <div class="col-10">
                <input class="form-control" type="date" id="example-date-input" name="date" v-model="filter.selectedDate">
            </div>
            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" v-on:click="sendForm">Save changes</button>
            </form>
        </div>
        </div>
    </div>
    </div>


    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import axios from 'axios'
    export default {
        components: { Multiselect },
        data() {
            return {
            filter: {           
                statusSelected: '',
                selected: null,
                selectedDate: '',
                title: '',
            },
            statusses: [],
            options: [],
            todos: [],
            title: '',
            search: '',
            }
        },
        mounted() {
           this.getTasks(),
           this.getStatuses()
        },
       
        methods: {
            getTasks() {
                axios.get('/api/tasks').then(
                    result => {
                        this.todos = result.data
                        console.log(this.todos)
                    }
                )
            },
           
            getStatuses() {
                axios.get('/api/taskStatuses').then(
                     result => {
                        this.statusses = result.data
                    }
                )
            },
            sendForm(){
                axios.post('/api/search', this.filter).then(
                     result => {
                         this.todos = result.data
                        console.log(result.data)
                    })
            },
        },
        computed: {
            filteredList() {
            return this.todos.filter(todo => {
                return todo.title.toLowerCase().includes(this.search.toLowerCase())
            })
        }
        },
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>