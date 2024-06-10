<script setup>
import { ref , onMounted , watch } from "vue";
import axios from 'axios';
import { useToastr } from '@/toastr';
import Spiner from '@/components/Spiner.vue';
import VueTailwindDatepicker from "vue-tailwind-datepicker";
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import TextAlign from '@tiptap/extension-text-align';
import Color from '@tiptap/extension-color'
import BoldIcon from 'vue-material-design-icons/FormatBold.vue'
import ItalicIcon from 'vue-material-design-icons/FormatItalic.vue'
import UnderlineIcon from 'vue-material-design-icons/FormatUnderline.vue'
import H1Icon from 'vue-material-design-icons/FormatHeader1.vue'
import H2Icon from 'vue-material-design-icons/FormatHeader2.vue'
import ListIcon from 'vue-material-design-icons/FormatListBulleted.vue'
import OrderedListIcon from 'vue-material-design-icons/FormatListNumbered.vue'
import CodeIcon from 'vue-material-design-icons/CodeTags.vue'
import HorizontalRuleIcon from 'vue-material-design-icons/Minus.vue'
import UndoIcon from 'vue-material-design-icons/Undo.vue'
import RedoIcon from 'vue-material-design-icons/Redo.vue'
import AlignLeftIcon from 'vue-material-design-icons/FormatAlignLeft.vue';
import AlignCenterIcon from 'vue-material-design-icons/FormatAlignCenter.vue';
import AlignRightIcon from 'vue-material-design-icons/FormatAlignRight.vue';
import AlignJustifyIcon from 'vue-material-design-icons/FormatAlignJustify.vue';


const props = defineProps({
  modelValue: String,
})
const toastr = useToastr();
const boldSignature = ref('');

const emit = defineEmits(['update:modelValue'])

const contenu = ref(props.modelValue);

const editor = useEditor({
  content: props.modelValue,
  onUpdate: ({ editor }) => {

    contenu.value = editor.getHTML();

    emit('update:modelValue', editor.getHTML())
  },
  extensions: [
    StarterKit,
    Underline,
    Color,
    TextAlign.configure({
      types: ['heading', 'paragraph'],
    }),
  ],
  editorProps: {
    attributes: {
      class:
        'border border-gray-400 p-4 min-h-[12rem] max-h-[12rem] overflow-y-auto outline-none prose max-w-none',
    },
  },
})

const fileInput = ref(null);
const attachments = ref([]);
const attachmentsnames = ref([]);


function handleButtonClick() {
    fileInput.value.click();
}



const showCCI = ref(false);


function toggleCCI() {
  showCCI.value = !showCCI.value;
}

const showCC = ref(false);


function toggleCC() {
  showCC.value = !showCC.value;
}


const expediteur = ref('');
const expediteurEmail = ref('');
const selectedRoles = ref([]);
const roles = ref([]);
const dateValueExpedition = ref('');
const dateValueLimite = ref('');
const sujet = ref('');
const to = ref('');
const cc = ref('');
const cci = ref('');
const expediteurPhone = ref('');
const expediteurOrg = ref('');





const fetchRoles = async () => {
  try {
    const response = await axios.get('/api/getroles');
    roles.value = response.data;
  } catch (error) {
    console.error('Error fetching roles:', error);
  }
};

const dropdownOpen = ref(false);

const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value;
};



watch(selectedRoles, async () => {
    try {
        const response = await axios.post('/api/emailsByRole', { selectedRoles: selectedRoles.value });
        cci.value = response.data.emails.join(',');
     

    } catch (error) {
        console.error('Error fetching emails by role:', error);
    }
});

const userSignature = ref('');


const fetchUserSignature = async () => {
    try {
        const response = await axios.get('/api/getuser-data');
        userSignature.value = response.data.signature;

        boldSignature.value = `<strong>${userSignature.value}</strong>`;

    } catch (error) {
        console.error('Error fetching user signature:', error);
    }
};


onMounted(() => {
    fetchRoles();
    fetchUserSignature();
  });

  const storeData = async () => {
  try {

    const formData = new FormData();


    formData.append('expediteur', expediteur.value);
    formData.append('expediteurOrg', expediteurOrg.value);
    formData.append('expediteurEmail', expediteurEmail.value);
    formData.append('dateValueExpedition', dateValueExpedition.value);
    formData.append('dateValueLimite', dateValueLimite.value);
    formData.append('sujet', sujet.value);
    formData.append('contenu', contenu.value);
    formData.append("to", to.value);
    formData.append("cc", cc.value);
    formData.append("cci", cci.value);
    formData.append("expediteurPhone", expediteurPhone.value);



    for (let i = 0; i < attachments.value.length; i++) {
      formData.append(`attachments[${i}]`, attachments.value[i]);
    }

    await axios.post('/api/store-data', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });

    console.log('Data stored successfully');
  } catch (error) {
    console.error('Error storing data:', error);
  }
};


const handleFileChange = (event) => {
    const files = event.target.files;

    for (let i = 0; i < files.length; i++) {
        attachmentsnames.value.push(files[i].name);
        attachments.value.push(files[i]);
    }
};
const removeAttachment = (index) => {
    attachmentsnames.value.splice(index, 1);
    attachments.value.splice(index, 1);
    fileInput.value = null;
};



const sendEmail = async () => {
    try {
        const formData = new FormData();
        formData.append("to", to.value);
        formData.append("cc", cc.value);
        formData.append("cci", cci.value);
        formData.append("sujet", sujet.value);
        formData.append("contenu", contenu.value);



        for (let i = 0; i < attachments.value.length; i++) {
            formData.append(`attachments[${i}]`, attachments.value[i]);
        }

        await axios.post('/api/send-email', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });



    } catch (error) {

        const errorMessage = error.response?.data?.message || 'Une erreur s\'est produite lors de l\'envoi de l\'email';
        toastr.error(errorMessage);
        throw error;
    }
};


function resetFormFields() {
  expediteur.value = '';
  expediteurEmail.value = '';
  expediteurOrg.value = '';
  dateValueExpedition.value = '';
  dateValueLimite.value = '';
  sujet.value = '';
  contenu.value = '';
  to.value = '';
  cc.value = '';
  cci.value = '';
  attachmentsnames.value = [];
  attachments.value = [];
}


const loading = ref(false);

const sendEmailStorData = async () => {
  try {
    loading.value = true;


    await sendEmail();
    await storeData();


    resetFormFields();
    toastr.success('Email envoyé avec succès!');
  } catch (error) {
    toastr.error('Une erreur s\'est produite lors de l\'envoi de l\'email');
  } finally {
    loading.value = false;
  }
};



</script>

<template>


    <nav class="text-sm font-semibold mb-12" aria-label="Breadcrumb">
      <ol class="list-none p-0 inline-flex">
        <li class="flex items-center text-blue-500">
          <a href="#" class="text-gray-700">Home</a>
          <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
        </li>
        <li class="flex items-center">
          <p href="#" class="text-gray-600">Créer des Emails</p>
        </li>
      </ol>
    </nav>

<div class="container">

     <form>
        <div class="grid gap-6 mb-6 md:grid-cols-2">

            <div>
                <label for="destinataire" class="block mb-2 text-sm font-medium text-gray-900">Nom de l'expéditeur</label>

                <input type="email"  v-model="expediteur" id="email" class="bg-white-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"  required />

            </div>

            <div>
                <label for="Organisation" class="block mb-2 text-sm font-medium text-gray-900">Organisation de l'expéditeur</label>
                <input type="text"  v-model="expediteurOrg" id="last_name" class="bg-white-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"  required />
            </div>
            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Telephone de l'expéditeur</label>
                <input type="tel" v-model="expediteurPhone" id="phone" class="bg-white-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"  required />
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Adresse e-mail</label>

                <input type="email" v-model="expediteurEmail" id="email" class="bg-white-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"  required />


            </div>






         <div>
         <label for="Date-expédition" class="block mb-2 text-sm font-medium text-gray-900">Date d'expédition</label>
         <vue-tailwind-datepicker  class="bg-white-50 border border-gray-400 text-gray-900 text-sm rounded-lg"   v-model="dateValueExpedition" as-single />
         </div>


         <div>
          <label for="Type-destinataire" class="block mb-2 text-sm font-medium text-gray-900">Type de destinataire</label>
          <div class="relative">
              <button type="button" @click="toggleDropdown" class="bg-white border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 text-left">
                  {{ dropdownOpen ? 'Cliquez ici pour fermer la sélection de rôles' : 'Cliquez ici pour ouvrir la sélection de rôles' }}
              </button>
              <div v-if="dropdownOpen" class="absolute z-10 bg-white border border-gray-400 text-gray-900 text-sm rounded-lg w-full mt-1">
                  <div v-for="role in roles" :key="role.id" class="p-2">
                      <label class="inline-flex items-center">
                          <input type="checkbox" :value="role.id" v-model="selectedRoles" class="form-checkbox">
                          <span class="ml-2">{{ role.name }}</span>
                      </label>
                  </div>
              </div>
          </div>
      </div>

            <div>
                <label for="Date-limite" class="block mb-2 text-sm font-medium text-gray-900">Date limite</label>
                <vue-tailwind-datepicker  class="bg-white-50 border border-gray-400 text-gray-900 text-sm rounded-lg"   v-model="dateValueLimite" as-single />
            </div>




      </div>
    </form>


    <div class="w-full bg-white shadow-xl rounded-lg flex overflow-x-auto custom-scrollbar">

<div class="flex-1 px-2">


    <div class="cont">


        <div class="mb-2 mt-4">
            <button @click="toggleCC" class="buttons-container  items-center justify-center px-4 h-10 text-base font-medium text-gray bg-gray-50 border border-gray-400 rounded-lg hover:bg-gray-100 hover:border-gray-500 hover:cursor-pointer mr-2" id="ccButton">CC</button>

            <button @click="toggleCCI" class="buttons-container  items-center justify-center px-4 h-10 text-base font-medium text-gray bg-gray-50 border border-gray-400 rounded-lg hover:bg-gray-100 hover:border-gray-500 hover:cursor-pointer" id="cciButton">CCI</button>
          </div>
        </div>

        <div class="input-container">

            <input  type="text" name="to" id="to" class="w-full py-2 px-3 border-b border-gray-400 rounded-lg focus:outline-none focus:ring-0 focus:border-transparent focus:border-b-gray-300 placeholder-gray-400 mt-2" placeholder="À" v-model="to">

    <input v-if="showCC" type="text" name="cc" id="cc" class="w-full py-2 px-3 border-b border-gray-400 rounded-lg focus:outline-none focus:ring-0 focus:border-transparent focus:border-b-gray-300 placeholder-gray-400 mt-2" placeholder="CC" v-model="cc">

    <input v-if="showCCI" type="text" name="cci" id="cci" class="w-full py-2 px-3 border-b rounded-lg border-gray-400 focus:outline-none focus:ring-0 focus:border-transparent focus:border-b-gray-300 placeholder-gray-400 mt-2" placeholder="CCI" v-model="cci">
</div>

<div>
    <input type="text" name="sujet" id="sujet" class="w-full py-2 px-3 border-b rounded-lg border-gray-400 focus:outline-none focus:ring-0 focus:border-transparent focus:border-b-gray-300 placeholder-gray-400 mt-2" placeholder="Sujet" v-model="sujet">
</div>






        <div class="mb-6 pt-4">
        <div class="mt-4">
            <section
            v-if="editor"
            class="buttons text-gray-700 flex items-center rounded-lg flex-wrap gap-x-4 border-t border-l border-r border-gray-400 p-4"
          >
            <button
              type="button"
              @click="editor.chain().focus().toggleBold().run()"
              :class="{ 'bg-gray-200 rounded': editor.isActive('bold') }"
              class="p-1"
            >
              <BoldIcon title="Bold" />
            </button>
            <button
              type="button"
              @click="editor.chain().focus().toggleItalic().run()"
              :class="{ 'bg-gray-200 rounded': editor.isActive('italic') }"
              class="p-1"
            >
              <ItalicIcon title="Italic" />
            </button>
            <button
              type="button"
              @click="editor.chain().focus().toggleUnderline().run()"
              :class="{ 'bg-gray-200 rounded': editor.isActive('underline') }"
              class="p-1"
            >
              <UnderlineIcon title="Underline" />
            </button>
            <button
              type="button"
              @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
              :class="{
                'bg-gray-200 rounded': editor.isActive('heading', { level: 1 }),
              }"
              class="p-1"
            >
              <H1Icon title="H1" />
            </button>
            <button
              type="button"
              @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
              :class="{
                'bg-gray-200 rounded': editor.isActive('heading', { level: 2 }),
              }"
              class="p-1"
            >
              <H2Icon title="H2" />
            </button>
            <button
              type="button"
              @click="editor.chain().focus().toggleBulletList().run()"
              :class="{ 'bg-gray-200 rounded': editor.isActive('bulletList') }"
              class="p-1"
            >
              <ListIcon title="Bullet List" />
            </button>
            <button
              type="button"
              @click="editor.chain().focus().toggleOrderedList().run()"
              :class="{ 'bg-gray-200 rounded': editor.isActive('orderedList') }"
              class="p-1"
            >
              <OrderedListIcon title="Ordered List" />
            </button>

            <button
              type="button"
              @click="editor.chain().focus().toggleCode().run()"
              :class="{ 'bg-gray-200 rounded': editor.isActive('code') }"
              class="p-1"
            >
              <CodeIcon title="Code" />
            </button>

            <button
              type="button"
              @click="editor.chain().focus().setHorizontalRule().run()"
              class="p-1"
            >
              <HorizontalRuleIcon title="Horizontal Rule" />
            </button>
            <button
              type="button"
              class="p-1 disabled:text-gray-400"
              @click="editor.chain().focus().undo().run()"
              :disabled="!editor.can().chain().focus().undo().run()"
            >
              <UndoIcon title="Undo" />
            </button>
            <button
              type="button"
              @click="editor.chain().focus().redo().run()"
              :disabled="!editor.can().chain().focus().redo().run()"
              class="p-1 disabled:text-gray-400"
            >
              <RedoIcon title="Redo" />
            </button>
            <div>
    <button  @click="editor.chain().focus().insertContent(boldSignature).run();"
     class="p-1 disabled:text-gray-400">
     <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a28.076 28.076 0 0 1-1.091 9M7.231 4.37a8.994 8.994 0 0 1 12.88 3.73M2.958 15S3 14.577 3 12a8.949 8.949 0 0 1 1.735-5.307m12.84 3.088A5.98 5.98 0 0 1 18 12a30 30 0 0 1-.464 6.232M6 12a6 6 0 0 1 9.352-4.974M4 21a5.964 5.964 0 0 1 1.01-3.328 5.15 5.15 0 0 0 .786-1.926m8.66 2.486a13.96 13.96 0 0 1-.962 2.683M7.5 19.336C9 17.092 9 14.845 9 12a3 3 0 1 1 6 0c0 .749 0 1.521-.031 2.311M12 12c0 3 0 6-2 9"/>
</svg>


         </button>



</div>
<div>
    <button @click.prevent="editor.chain().focus().setTextAlign('left').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }" class="p-1 disabled:text-gray-400">
          <AlignLeftIcon class="w-6 h-6" />
        </button>
        <button @click.prevent="editor.chain().focus().setTextAlign('center').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }" class="p-1 disabled:text-gray-400">
          <AlignCenterIcon class="w-6 h-6" />
        </button>
        <button @click.prevent="editor.chain().focus().setTextAlign('right').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }" class="p-1 disabled:text-gray-400">
          <AlignRightIcon class="w-6 h-6" />
        </button>
        <button @click.prevent="editor.chain().focus().setTextAlign('justify').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'justify' }) }"class="p-1 disabled:text-gray-400">
          <AlignJustifyIcon class="w-6 h-6" />
        </button>

</div>
          </section>

             <editor-content  :editor="editor"/>


        </div>






        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center space-x-2">
                <button @click="sendEmailStorData" class="bg-blue-500 hover:bg-bleu-700 rounded-lg px-12 py-1.5 text-gray-100 hover:shadow-xl transition duration-150">Envoyer</button>
                <div style="display: flex; align-items: center;">
        <input type="file" style="display: none;" ref="fileInput" @change="handleFileChange" multiple>
        <button @click="handleButtonClick" style="margin-right: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 hover:text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
            </svg>
        </button>
        <ul style="display: flex; list-style: none; padding-left: 0; margin: 0;">
    <li v-for="(attachmentname, index) in attachmentsnames" :key="index" style="margin-right: 10px;">
        {{ attachmentname }}
        <button @click="removeAttachment(index)">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pt-1 text-black-500 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 1c-4.417 0-8 3.583-8 8s3.583 8 8 8 8-3.583 8-8-3.583-8-8-8zm4.707 12.707a1 1 0 0 1-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 1 1-1.414-1.414L8.586 10 5.293 6.707a1 1 0 0 1 1.414-1.414L10 8.586l3.293-3.293a1 1 0 0 1 1.414 1.414L11.414 10l3.293 3.293z" clip-rule="evenodd" />
            </svg>
        </button>
    </li>
</ul>


    </div>

            </div>

        </div>
    </div>
</div>
</div>
</div>

<div>


  </div>

  <div>

  </div>


  <Spiner v-if="loading" />

</template>

<style scoped>
.container {
  margin-left: auto;
  margin-right: auto;
  width: 60%;
}

.input-field {
    width: 100%;
    padding: 0.5rem 1rem;
    border: none;
    border-bottom: 1px solid #ccc;
    outline: none;
  }

  .input-field:focus {
    border-color: #ccc;

  }
  .cont {
    display: flex;
    justify-content: flex-end;
}

.buttons-container {
    margin-left: auto;
}

 .dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-toggle {
 width: 457px;
  cursor: pointer;

}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  background-color: #fff;
  border: 1px solid #ced4da;
  padding: 0.5rem;
}

.checkbox {
  display: block;
}

</style>
