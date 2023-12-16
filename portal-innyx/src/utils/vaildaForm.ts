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
    invalidEmail ?: boolean; 
    invalidPassword ?: boolean; 
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