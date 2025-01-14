<template>
    <h1>Installations</h1>
    <h2 v-if="!isEdit">Create Installation</h2>
    <h2 v-else>Edit Installation</h2>
    <form>
        <label for="installation_name">Name</label>
        <input v-model="installationName" type="text" name="installation_name" id="installation_name">
        <label for="installation_color">Color</label>
        <input v-model="installationColor" type="color" value="#ff0000" name="installation_color"
               id="installation_color">
        <button v-if="!isEdit" type="button" @click.prevent="createInstallation">Create Installation</button>
        <button v-else type="button" @click.prevent="updateInstallation">Save Installation</button>
    </form>
    <h2>Installations</h2>
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Color</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="installation in installations" :key="installation.id">
            <td>{{ installation.name }}</td>
            <td :style="`background-color: ${installation.color}`">{{ installation.color }}</td>
            <td class="actions">
                <button @click.prevent="deleteInstallation(installation.id)">Delete</button>
                <button @click.prevent="editInstallation(installation)">Edit</button>
            </td>
        </tr>
        </tbody>
    </table>
    <span class="message" v-if="installations?.length === 0">No installations found</span>
    <span class="message" v-if="errorMessage">{{ errorMessage }}</span>
</template>

<script setup>
import axios from "axios";
import {ref, onMounted} from "vue";

const installations = ref();
const isEdit = ref(false);
const editId = ref(null);
const errorMessage = ref(null);
const installationName = defineModel('installationName')
const installationColor = defineModel('installationColor')

installationColor.value = "#ff0000";

const getInstallations = async () => {
    try {
        const {data} = await axios.get("/api/v1/installation");
        installations.value = data.data;
    } catch (error) {
        errorMessage.value = (error.message);
    }
};

const createInstallation = async () => {
    try {
        const {data} = await axios.post("/api/v1/installation", {
            name: installationName.value,
            color: installationColor.value
        });
        installations.value.push(data.data);
        installationName.value = null;
        installationColor.value = '#ff0000';
    } catch (error) {
        errorMessage.value = (error.message);
    }
}

const editInstallation = (installation) => {
    isEdit.value = true;
    editId.value = installation.id;
    installationName.value = installation.name;
    installationColor.value = installation.color;
}

const updateInstallation = async () => {
    try {
        const {data} = await axios.put(`/api/v1/installation/${editId.value}`, {
            id: editId.value,
            name: installationName.value,
            color: installationColor.value,
        });
        installations.value = installations.value.map(installation => installation.id === editId.value ? data.data : installation);

        isEdit.value = false;
        editId.value = null;
        installationName.value = null;
        installationColor.value = '#ff0000';
    } catch (error) {
        errorMessage.value = (error.message);
    }
}

const deleteInstallation = async (installationId) => {
    try {
        await axios.delete(`/api/v1/installation/${4}`);
        installations.value = installations.value.filter(installation => installation.id !== installationId);
    } catch (error) {
        errorMessage.value = (error.message);
    }
}

onMounted(() => {
    getInstallations();
});
</script>

