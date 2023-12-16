<template>
    <div class="card flex justify-content-center">
        <form class="flex flex-column gap-2">
            <div class="flex flex-column gap-2">
                <label for="nome">Nome do Produto</label>
                <InputText id="nome" v-model="formProduto.nome" type="text" :class="{ 'p-invalid': errorMessageNome }"
                    aria-describedby="text-error" />
            </div>
            <div class="flex flex-column gap-2">
                <label for="descricao">Descrição</label>
                <InputText id="descricao" v-model="formProduto.descricao" type="text"
                    :class="{ 'p-invalid': errorMessageDescricao }" aria-describedby="text-error" />
            </div>
            <div class="flex flex-column gap-2">
                <label for="preco">Preço</label>
                <InputNumber id="preco" v-model="formProduto.preco" showButtons mode="currency" currency="BRL"
                    :class="{ 'p-invalid': errorMessagePreco }" aria-describedby="text-error" />
            </div>
            <div class="flex flex-column gap-2">
                <label for="dataValidade">Data de validade</label>
                <InputMask id="dataValidade" v-model="formProduto.data_validade"
                    :class="{ 'p-invalid': errorMessageDataValidade }" aria-describedby="text-error"
                    placeholder="99/99/9999" mask="99/99/9999" slotChar="mm/dd/yyyy" />
            </div>
            <div class="flex flex-column gap-2">
                <label for="nome">Categoria</label>
                <Dropdown v-model="formProduto.categoria.id" :options="categorias" optionLabel="nome" optionValue="id"
                    placeholder="Selecione a categoria" class="w-full md:w-12" />

            </div>
            <div class="flex flex-column gap-2">
                <label for="imagem">Imagem</label>
                <FileUpload mode="basic" id="imagem" name="image[]" accept="image/*" :maxFileSize="1000000"
                    @select="saveImg" chooseLabel="Upload" />
            </div>
            <Image v-if="preview" :src="fileSelected" alt="Image" width="250" preview />
            <div class="row mt-3 mx-auto">
                <Button label="Cancelar" icon="pi pi-times" severity="secondary" text @click="emit('close')" />
                <Button label="Salvar" icon="pi pi-check" :loading="loading" text @click="onSubmit" />
            </div>
        </form>
        <Toast />
    </div>
</template>

<script setup lang="ts">
import Dropdown from 'primevue/dropdown';
import FileUpload from 'primevue/fileupload';
import InputMask from 'primevue/inputmask';
import InputNumber from 'primevue/inputnumber';
import InputText from 'primevue/inputtext';
import { ProdutoService } from '@/services/produtos';
import { ref, onMounted } from 'vue';
import Image from 'primevue/image';
import Button from 'primevue/button';
import { validaFormProduto, type IProduto } from '@/utils/vaildaForm';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const emit = defineEmits(['close', 'confirm'])



const formProduto = ref({} as IProduto)
const toast = useToast();

const errorMessageNome = ref(false)
const errorMessageDescricao = ref(false)
const errorMessagePreco = ref(false)
const errorMessageDataValidade = ref(false)
const files = ref()
const fileSelected = ref()

const loading = ref(false)
const preview = ref(false)

const { product } = defineProps({
    product: { type: Object, required: true },
})

formProduto.value = product

const onSubmit = () => {
    loading.value = true
    const { invalidNome, invalidDescricao, invalidPreco, invalidDataValidade, error, message } = validaFormProduto(formProduto.value)

    errorMessageNome.value = invalidNome ?? false
    errorMessageDescricao.value = invalidDescricao ?? false
    errorMessagePreco.value = invalidPreco ?? false
    errorMessageDataValidade.value = invalidDataValidade ?? false

    if (error) {
        loading.value = false
        return toast.add({ severity: 'error', summary: 'Alerta', detail: message, life: 3000 });
    }

    let form = {
        nome: formProduto.value.nome,
        descricao: formProduto.value.descricao,
        preco: formProduto.value.preco,
        data_validade: formProduto.value.data_validade.toString(),
        categoria_id: formProduto.value.categoria.id,
        imagem: fileSelected.value
    }


    ProdutoService.saveData(form, formProduto.value.id).then(() => {
        toast.add({ severity: 'success', summary: 'Sucesso', detail: "Produto editado com sucesso!", life: 3000 })
        loading.value = false
        emit('confirm')
    }).catch(({ response: { data: { message } } }) => {
        loading.value = false
        console.log(message)
        if (!message)
            return toast.add({ severity: 'error', summary: 'Alerta', detail: "Falha ao editar produto!", life: 3000 })
        return toast.add({ severity: 'error', summary: 'Alerta', detail: message, life: 3000 })

    })



}

const saveImg = (event: any) => {
    files.value = event.files;
    files.value.forEach((file) => {
        let reader = new FileReader()
        reader.onload = (event: any) => {
            fileSelected.value = event.target.result
        }
        reader.readAsDataURL(file)
        preview.value = true
    });
}

onMounted(() => loadCategorias())

const categorias = ref([])

const loadCategorias = () => ProdutoService.getCategorias().then(({ data }) => categorias.value = data)


</script>