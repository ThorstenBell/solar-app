<template>
    <div>
        <h1>Energy Data</h1>
        <div class="graph-container">
            <div class="graph">
                <h2>Energy Usage</h2>
                <div class="graph-wrapper">
                    <Scatter v-if="isDataLoaded" :data="usageChartData" :options="chartOptions"/>
                    <p v-else>Loading chart...</p>
                </div>
            </div>
            <div class="graph">
                <h2>Energy Production</h2>
                <div class="graph-wrapper">
                    <Scatter v-if="isDataLoaded" :data="productionChartData" :options="chartOptions"/>
                    <p v-else>Loading chart...</p>
                </div>
            </div>
        </div>
        <h2 v-if="!isEdit">Create Energy Record</h2>
        <h2 v-else>Edit Energy Record</h2>
        <form>
            <label for="installation_id">Installation</label>
            <select v-model="installationId" id="installation_id" name="installation_id">
                <option v-for="installation in installations" :key="installation.id" :value="installation.id">
                    {{ installation.name }}
                </option>
            </select>
            <label for="energy_produced">Energy Produced</label>
            <input v-model="energyProduced" type="number" name="energy_produced" id="energy_produced" min="0">
            <label for="energy_consumed">Energy Consumed</label>
            <input v-model="energyConsumed" type="number" name="energy_consumed" id="energy_consumed" min="0">
            <label for="date">Date</label>
            <input v-model="energyDate" type="date" name="date">
            <button  v-if="!isEdit" type="button" @click.prevent="createEnergyRecord">Add Energy Info</button>
            <button  v-else type="button" @click.prevent="updateEnergyRecord">Save Energy Info</button>
        </form>

        <h2>Energy Records</h2>
        <table>
            <thead>
            <tr>
                <th>Installation</th>
                <th>Energy Produced</th>
                <th>Energy Consumed</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="energyRecord in energyData" :key="energyRecord.id">
                <td>{{ getInstallationName(energyRecord.installation_id) }}</td>
                <td>{{ energyRecord.energy_produced }}</td>
                <td>{{ energyRecord.energy_consumed }}</td>
                <td>{{ energyRecord.date }}</td>
                <td class="actions">
                    <button @click.prevent="deleteEnergyRecord(energyRecord.id)">Delete</button>
                    <button @click.prevent="editEnergyRecord(energyRecord)">Edit</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import axios from "axios";
import {ref, onMounted} from "vue";
import {
    Chart as ChartJS,
    LinearScale,
    PointElement,
    LineElement,
    Tooltip,
    Legend,
    CategoryScale,
    TimeScale,
    Title
} from 'chart.js'
import {Scatter} from 'vue-chartjs'
import 'chartjs-adapter-date-fns';

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    TimeScale,
    Legend
)

const energyData = ref();
const installations = ref();
const isDataLoaded = ref(false);
const isEdit = ref(false);
const editId = ref(null);
const installationId = defineModel('installationId');
const energyProduced = defineModel('energyProduced');
const energyConsumed = defineModel('energyConsumed');
const energyDate = defineModel('energyDate');

const usageChartData = ref({
    labels: [],
    datasets: []
});

const productionChartData = ref({
    labels: [],
    datasets: []
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        x: {
            type: 'time',
            time: {
                unit: 'day',
                tooltipFormat: 'll',
            },
            title: {
                display: true,
                text: 'Date',
            },
        },
        y: {
            beginAtZero: true,
        }
    }
}

const createGraphData = (data) => {
    data.forEach(energyRecord => {
        usageChartData.value.datasets.push({
            label: energyRecord.installation_name,
            fill: false,
            borderColor: energyRecord.installation_color,
            backgroundColor: energyRecord.installation_color,
            borderWidth: 2,
            showLine: true,
            data: energyRecord.data.map(item => ({x: item.date, y: item.energy_consumed}))
        });
        productionChartData.value.datasets.push({
            label: energyRecord.installation_name,
            fill: false,
            borderColor: energyRecord.installation_color,
            backgroundColor: energyRecord.installation_color,
            borderWidth: 2,
            showLine: true,
            data: energyRecord.data.map(item => ({x: item.date, y: item.energy_produced}))
        });
    });
    isDataLoaded.value = true;
}

const getEnergyData = async () => {
    try {
        const {data} = await axios.get("/api/v1/energy-usage");
        energyData.value = data.data;
        installationId.value = null;
        energyProduced.value = null;
        energyConsumed.value = null;
        energyDate.value = null;
        const groupedData = data.data.reduce((acc, item) => {
            let group = acc.find(group => group.installation_id === item.installation_id);
            if (!group) {
                const installation = installations.value.find(installation => installation.id === item.installation_id);
                group = {
                    installation_id: item.installation_id,
                    installation_name: installation.name,
                    installation_color: installation.color,
                    data: []
                };
                acc.push(group);
            }
            group.data.push({
                id: item.id,
                energy_produced: item.energy_produced,
                energy_consumed: item.energy_consumed,
                date: item.date
            });

            return acc;
        }, []);
        createGraphData(groupedData);
    } catch (error) {
        console.log(error.message);
    }
};

const getInstallations = async () => {
    try {
        const {data} = await axios.get("/api/v1/installation");
        installations.value = data.data;
    } catch (error) {
        console.log(error.message);
    }
};

const getInstallationName = (installationId) => {
    const installation = installations.value.find(installation => installation.id === installationId);
    return installation ? installation.name : '';
}

const createEnergyRecord = async () => {
    try {
        const {data} = await axios.post("/api/v1/energy-usage", {
            installation_id: installationId.value,
            energy_produced: energyProduced.value,
            energy_consumed: energyConsumed.value,
            date: energyDate.value
        });
        energyData.value.push(data.data);
        installationId.value = null;
        energyProduced.value = null;
        energyConsumed.value = null;
        energyDate.value = null;
    } catch (error) {
        console.log(error.message);
    }
}

const editEnergyRecord = (energyRecord) => {
    isEdit.value = true;
    editId.value = energyRecord.id;
    installationId.value = energyRecord.installation_id;
    energyProduced.value = energyRecord.energy_produced;
    energyConsumed.value = energyRecord.energy_consumed;
    energyDate.value = energyRecord.date;
}

const updateEnergyRecord = async () => {
    try {
        const {data} = await axios.put(`/api/v1/energy-usage/${editId.value}`, {
            id: editId.value,
            installation_id: installationId.value,
            energy_produced: energyProduced.value,
            energy_consumed: energyConsumed.value,
            date: energyDate.value
        });
        energyData.value = energyData.value.map(energyRecord => energyRecord.id === editId.value ? data.data : energyRecord);

        isEdit.value = false;
        editId.value = null;
        installationId.value = null;
        energyProduced.value = null;
        energyConsumed.value = null;
        energyDate.value = null;
    } catch (error) {
        console.log(error.message);
    }
}

const deleteEnergyRecord = async (energyRecordId) => {
    try {
        await axios.delete(`/api/v1/energy-usage/${energyRecordId}`);
        energyData.value = energyData.value.filter(energyRecord => energyRecord.id !== energyRecordId);
    } catch (error) {
        console.log(error.message);
    }
}

onMounted(() => {
    getInstallations();
    getEnergyData();
})
</script>

<style>
.graph-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
}

.graph-wrapper {
    width: 100%;
    height: 40rem;
}

@media screen and (max-width: 768px) {
    .graph-container {
        grid-template-columns: 1fr;
    }
}
</style>
