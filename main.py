def validar_valor(func):
    def wrapper(self, valor):
        if valor <= 0:
            raise ValueError("Valor deve ser maior que zero")
        return func(self, valor)
    return wrapper

class Item:
    def __init__(self, valor, descricao):
        self.valor = valor
        self.descricao = descricao

    @property
    def valor(self):
        return self.__valor

    @valor.setter
    @validar_valor
    def valor(self, valor):
        self.__valor = valor

    @property
    def descricao(self):
        return self.__descricao

    @descricao.setter
    def descricao(self, descricao):
        self.__descricao = descricao

item = Item(100, "Mouse")
item.valor = 10