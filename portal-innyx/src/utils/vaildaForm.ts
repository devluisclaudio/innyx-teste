export const validaEmail = (email: string) => {
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email) {
        return { error: true, message: 'Email é obrigatório!', invalidEmail: true }
    }
    if (!regexEmail.test(email)) {
        return { error: true, message: 'Email inválido!', invalidEmail: true }
    }

    return { error: false, message: '' }
}

export const validaSenha = (password: string) => {
    if (!password) {
        return { error: true, message: 'Senha é obrigatória!', invalidPassword: true }
    }

    return { error: false, message: '' }
}

export type IvalidaForm = (email: string, password: string) => {
    error: boolean;
    message: string;
    invalidEmail?: boolean;
    invalidPassword?: boolean;
}


export const validaFormLogin = (email: string, password: string): ReturnType<IvalidaForm> => {
    if (!email && !password) {
        return { error: true, message: 'Todos os campos são obrigatórios!', invalidEmail: true, invalidPassword: true }
    }

    const resultEmail = validaEmail(email)

    if (resultEmail.error)
        return resultEmail

    const resultSenha = validaSenha(password)

    if (resultSenha.error)
        return resultSenha

    return { error: false, message: '' }
}

export type IProduto = {
    id?: number
    nome: string;
    descricao: string;
    preco: number;
    data_validade: string;
    categoria: {
        id: number,
        nome: string
    }
}

export type IvalidaFormProduto = ({ nome, descricao, preco, data_validade }: IProduto) => {
    error: boolean;
    message: string;
    invalidNome?: boolean;
    invalidDescricao?: boolean;
    invalidDataValidade?: boolean;
    invalidPreco?: boolean;
}

export const validaFormProduto = ({ nome, descricao, preco, data_validade }: IProduto): ReturnType<IvalidaFormProduto> => {
    if (!nome && !descricao && !preco && !data_validade) {
        return { error: true, message: 'Todos os campos são obrigatórios!', invalidNome: true, invalidDescricao: true }
    }

    if (!nome)
        return { error: true, message: 'Nome é obrigatório!', invalidNome: true }

    if (!descricao)
        return { error: true, message: 'Descrição é obrigatória!', invalidDescricao: true }

    if (!preco)
        return { error: true, message: 'Preço é obrigatório!', invalidPreco: true }

    if (!data_validade)
        return { error: true, message: 'Data de validade é obrigatória!', invalidDataValidade: true }

    if (!dataMaiorQueHoje(data_validade))
        return { error: true, message: 'Data de validade tem que ser maior que hoje!', invalidDataValidade: true }


    return { error: false, message: '' }
}

export const dataMaiorQueHoje = (data: string): boolean => {
    const hoje = new Date();
    const partes = data.split('/')
    const dia = parseInt(partes[0], 10)
    const mes = parseInt(partes[1], 10) - 1
    const ano = parseInt(partes[2], 10)

    const customDate = new Date(ano, mes, dia)
    return customDate.getTime() > hoje.getTime();
}