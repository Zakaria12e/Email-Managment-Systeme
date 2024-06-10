<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import Spiner from '@/components/Spiner.vue';
import { useToastr } from '@/toastr';


const toastr = useToastr();
const email = ref(null);
const route = useRoute();
const showToDropdown = ref(false);
const showCCDropdown = ref(false);
const showCCIDropdown = ref(false);






const fileInput = ref(null);
const attachments = ref([]);
const attachmentsnames = ref([]);




const showCCI = ref(false);


function toggleCCI() {
  showCCI.value = !showCCI.value;
}

const showCC = ref(false);


function toggleCC() {
  showCC.value = !showCC.value;
}







const renderHtml = (content) => {
  return content;
};


const toggleToDropdown = () => {
  showToDropdown.value = !showToDropdown.value;
};

const toggleCCDropdown = () => {
  showCCDropdown.value = !showCCDropdown.value;
};

const toggleCCIDropdown = () => {
  showCCIDropdown.value = !showCCIDropdown.value;
};



const formatDate = (createdAt) => {
  const date = new Date(createdAt);
  return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
};

const calculateTimeSinceSent = (createdAt) => {
  const createdDate = new Date(createdAt);
  const now = new Date();
  const timeDifference = now.getTime() - createdDate.getTime();

  const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
  const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));

  let result = '';
  if (days > 0) {
    result += `${days} jour${days > 1 ? 's' : ''} `;
  }
  if (hours > 0) {
    result += `${hours} heure${hours > 1 ? 's' : ''} `;
  }
  if (minutes > 0) {
    result += `${minutes} minute${minutes > 1 ? 's' : ''} `;
  }

  return result === '' ? 'À l instant' : result + ' passé';
};


onMounted(async () => {
  try {
    const response = await axios.get(`/api/email/${route.params.id}`);
     email.value = response.data;

  } catch (error) {
    console.error('Échec de la récupération de lemail :', error);
  }
});
</script>

<template>
  

    <div class="pr-8">
      <div v-if="email" class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-semibold mb-4 text-indigo-900">{{ email.sujet }}</h2>
        <div class="flex flex-wrap items-center text-gray-600 mb-2">
          <div class="flex items-center mr-4">
            <template v-if="email.to">
              <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="font-semibold">À :</span>
              <button @click="toggleToDropdown" class="text-gray-400 hover:text-gray-700 focus:outline-none ml-2">
                <svg v-if="showToDropdown" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                </svg>
              </button>
              <div>
                <div v-show="showToDropdown" class="absolute text-blue-500 z-10 mt-2 bg-white p-3 border border-gray-200 rounded-md shadow-lg">
                  <ul>
                    <li v-for="(email, index) in email.to.split(',')" :key="index">{{ email.trim() }}</li>
                  </ul>
                </div>
              </div>
            </template>
          </div>
          <template v-if="email.cc">
            <div class="flex items-center mr-4">
              <span class="font-semibold">CC</span>
              <button @click="toggleCCDropdown" class="text-gray-400 hover:text-gray-700 focus:outline-none ml-2">
                <svg v-if="showCCDropdown" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                </svg>
              </button>
            </div>
            <div>
              <div v-show="showCCDropdown" class="absolute p-3 text-blue-500 z-10 mt-2 bg-white border border-gray-200 rounded-md shadow-lg">
                <ul>
                  <li v-for="(email, index) in email.cc.split(',')" :key="index">{{ email.trim() }}</li>
                </ul>
              </div>
            </div>
          </template>
          <template v-if="email.cci">
            <div class="flex items-center">
              <span class="font-semibold">CCI</span>
              <button @click="toggleCCIDropdown" class="text-gray-400 hover:text-gray-700 focus:outline-none ml-2">
                <svg v-if="showCCIDropdown" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                </svg>
              </button>
            </div>
            <div>
              <div v-show="showCCIDropdown" class="absolute text-blue-500 z-10 mt-2 bg-white p-3 border border-gray-200 rounded-md shadow-lg">
                <ul>
                  <li v-for="(email, index) in email.cci.split(',')" :key="index">{{ email.trim() }}</li>
                </ul>
              </div>
            </div>
          </template>

        </div>
        <div class="mt-6" v-html="renderHtml(email.contenu)"></div>
        <div class="mt-6" v-if="email.attachments && email.attachments.length">
          <h2 class="text-xl font-semibold mb-4 text-gray-700">Pièces jointes</h2>
          <ul class="flex flex-wrap gap-4">
            <li v-for="attachment in email.attachments" :key="attachment.id">
              {{ attachment.nom_piece }}
            </li>
          </ul>
        </div>
        <hr class="mt-6 mb-6">
        <div>
          <div class="text-gray-600"><b>Date d'expédition :</b> {{ email.date_exped }}</div>
          <div class="text-red-500" v-if="email.dead_line"><b>Date limite :</b> {{ email.dead_line }}</div>

        </div>

        <div class="mt-auto text-right text-gray-600">Envoyé : {{ formatDate(email.created_at) }} ({{ calculateTimeSinceSent(email.created_at) }})</div>
      </div>
      <div v-else>
        <Spiner />
      </div>
    </div>
  </template>
