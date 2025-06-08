describe('Cek fungsi halaman mahasiswa', () => {
  it('Cek perilaku sistem jika membuka halaman data mahasiswa', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-student-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })
  })

  it('Cek perilaku sistem jika menyaring data mahasiswa', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-student-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })

    cy.get('[data-cy="input-name"]').type('Ade Susilo')
    cy.get('[data-cy="input-username"]').type('adesusilo')
    cy.get('[data-cy="input-class-year"]').type('2021')
    cy.get('[data-cy="select-program-study"]').select('3')
    cy.get('[data-cy="select-submission-status"]').select('accepted')
    cy.get('[data-cy="btn-submit"]').click()

    cy.contains('tr', 'Ade Susilo').should('exist');
  })

  it('Cek perilaku sistem jika menambah data mahasiswa', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-student-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })

    cy.get('[data-cy="btn-link-add-student"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management/create')
    })
    cy.get('[data-cy="input-username"]').type('testusername')
    cy.get('[data-cy="input-first-name"]').type('test judul')
    cy.get('[data-cy="input-last-name"]').type('test judul')
    cy.get('[data-cy="select-gender"]').select(1)
    cy.get('[data-cy="input-class-year"]').type('2021')
    cy.get('[data-cy="input-email"]').type('emailtest@gmail.com')
    cy.get('[data-cy="input-password"]').type('userpass')
    cy.get('[data-cy="select-program-study"]').select(3)
    cy.get('[data-cy="input-profile-picture"]').selectFile("Cypress/images/github.png");
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })

    cy.contains('Data Mahasiswa Ditambahkan');
  })

  it('Cek perilaku sistem jika menambah data mahasiswa dengan data username yang sudah digunakan', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-student-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })

    cy.get('[data-cy="btn-link-add-student"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management/create')
    })
    cy.get('[data-cy="input-username"]').type('testusername')
    cy.get('[data-cy="input-first-name"]').type('firstname')
    cy.get('[data-cy="input-last-name"]').type('lastname')
    cy.get('[data-cy="select-gender"]').select(1)
    cy.get('[data-cy="input-class-year"]').type('2021')
    cy.get('[data-cy="input-email"]').type('emailtest@gmail.com')
    cy.get('[data-cy="input-password"]').type('userpass')
    cy.get('[data-cy="select-program-study"]').select(3)
    cy.get('[data-cy="input-profile-picture"]').selectFile("Cypress/images/github.png");
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management/create')
    })

    cy.contains('Username Sudah Digunakan, Email Sudah Digunakan');
  })

  it('Cek perilaku sistem jika edit data mahasiswa', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-student-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })

    cy.get('.table').find('.btn-edit').first().click();

    cy.get('[data-cy="input-username"]').clear().type('testusername_edit')
    cy.get('[data-cy="input-first-name"]').clear().type('firstname_edit')
    cy.get('[data-cy="input-last-name"]').clear().type('lastname_edit')
    cy.get('[data-cy="select-gender"]').select(2)
    cy.get('[data-cy="input-class-year"]').clear().type('2022')
    cy.get('[data-cy="input-email"]').clear().type('emailtestedit@gmail.com')
    cy.get('[data-cy="input-password"]').clear().type('11111111')
    cy.get('[data-cy="select-program-study"]').select(2)
    cy.get('[data-cy="input-profile-picture"]').selectFile("Cypress/images/github.png");
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })

    cy.contains('Data Mahasiswa Diperbarui');
  })

  it('Cek perilaku sistem jika hapus data mahasiswa', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-student-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })

    cy.get('.table').find('.btn-delete').first().click();

    cy.get('[data-cy="btn-delete-confirm"]').click();


    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })

    cy.contains('Data Mahasiswa Dihapus');
  })

  it('Cek perilaku sistem jika melihat detail data mahasiswa', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-student-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })

    cy.get('.table').find('.btn-detail').first().click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/student-management')
    })
  })

  it('Cek perilaku sistem jika mengimpor data mahasiswa dari file excel', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-student-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })

    cy.get('[data-cy="btn-import-excel"]').click();
    cy.get('[data-cy="btn-download-template"]').click();
    cy.get('[data-cy="select-import-program-study"]').select(1);
    cy.get('[data-cy="input-upload-template"]').selectFile("Cypress/document/Template_Mahasiswa.xlsx", { force: true });
    cy.get('[data-cy="btn-submit-template"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/student-management')
    })

    cy.contains('Impor Berhasil');
  })
})
