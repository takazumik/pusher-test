<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h1>Todoリスト</h1>
        <ul>
          <li v-for="(todo, index) in todos" :key="index">{{ todo['name'] }}</li>
        </ul>
        <input type="text" v-model="newTodo" @blur="addTodo" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      todos: [],
      newTodo: "",
    };
  },
  mounted() {
    axios.get("/api/todos").then((response) => (this.todos = response.data));
    window.Echo.private("todo-added-channel." + window.user["id"]).listen(
      "TodoAdded",
      (response) => {
        this.todos.push(response.todo);
      }
    );
  },
  methods: {
    addTodo() {
      axios
        .post("/api/todos", {
          name: this.newTodo,
          user_id: window.user["id"],
        })
        .then((response) => this.todos.push(response.data));

      this.newTodo = "";
    },
  },
};
</script>