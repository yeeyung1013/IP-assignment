import requests
import pandas as pd
from pandas import ExcelWriter
import matplotlib.pyplot as plt
import logging
import os
import json

logging.basicConfig(filename='event_sales_report.log', level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')

def login():
    logging.info("Displaying main menu")
    print("Event Sales Report")
    print("1 - Login")
    print("2 - Exit")
    
    choice = input("Choose an option: ")
    
    if choice == '1':
        email = input("Enter email: ")
        password = input("Enter password: ")

        response = requests.post("http://localhost/villain/assets/api/ticketAPI.php?action=login", data={'email': email, 'password': password})
        data = response.json()

        if data['status'] == 'success':
            admin_name = data['admin']['name']
            logging.info(f"Admin {admin_name} logged in successfully")
            welcome_menu(admin_name)
        else:
            logging.warning("Failed login attempt")
            print("Login failed. Try again.")
            login()
    elif choice == '2':
        logging.info("User exited the application")
        exit()
    else:
        logging.error("Invalid menu choice")
        print("Invalid choice. Please choose again.")
        login()

def welcome_menu(admin_name):  
    logging.info(f"Admin {admin_name} accessing the main menu")
    print(f"Welcome, {admin_name}")
    print("1 - Display event details")
    print("2 - Search event ID to view the sales report")
    print("3 - Logout")
    
    choice = input("Choose an option: ")
    
    if choice == '1':
        display_event_details(admin_name)
    elif choice == '2':
        event_id = input("Enter Event ID: ")
        view_sales_report(admin_name, event_id)
    elif choice == '3':
        logging.info(f"Admin {admin_name} logged out")
        print("Logging out...")
        login()
    else:
        logging.error("Invalid menu choice in the welcome menu")
        print("Invalid choice. Please choose again.")
        welcome_menu(admin_name)

def display_event_details(admin_name):
    logging.info(f"Admin {admin_name} requested event details")
    response = requests.get("http://localhost/villain/assets/api/ticketAPI.php?action=events")
    events = response.json()['events']
    
    print("Event Details:")
    for event in events:
        print(f"Event ID: {event['EventID']}, Name: {event['EventName']}, Location: {event['location']}")
    
    welcome_menu(admin_name)

def view_sales_report(admin_name, event_id):
    logging.info(f"Admin {admin_name} is viewing sales report for event ID: {event_id}")
    response = requests.post("http://localhost/villain/assets/api/ticketAPI.php?action=sales_report", data={'event_id': event_id})
    data = response.json()
    
    if data['status'] == 'success':
        print("Sales Report:")
        print(f"Total Sales: {data['total_sales']}")
        for category, sales in data['category_sales'].items():
            print(f"Category: {category}, Sold: {sales}")
        
        download_choice = input("Do you want to generate an Excel report? (y/n): ")
        if download_choice.lower() == 'y':
            generate_excel_report(data,event_id)
        else:
            welcome_menu(admin_name)
    else:
        logging.warning(f"Sales report not found for event ID: {event_id}")
        print(data['message'])
        welcome_menu(admin_name)

def generate_excel_report(sales_data, event_id):
    logging.info(f"Generating Excel report for event ID: {event_id}")

    try:
        event_response = requests.post("http://localhost/villain/assets/api/ticketAPI.php?action=event_details", data={'event_id': event_id})
        event_data = event_response.json()
        event_name = event_data.get('event_name', 'Unknown Event')
        event_date = event_data.get('event_date', 'Unknown Date')

        tickets = sales_data.get('tickets', [])
        if not tickets:
            print("No ticket data available for this event. Excel report will not be generated.")
            return

        df = pd.DataFrame(tickets)

        writer = pd.ExcelWriter('sales_report.xlsx', engine='xlsxwriter')
        workbook = writer.book

        worksheet = workbook.add_worksheet('Sales Report')

        title_format = workbook.add_format({'bold': True, 'font_size': 16, 'align': 'center'})
        worksheet.merge_range('A1:H1', 'Event Sales Report', title_format)

        worksheet.merge_range('A2:H2', f"Event: {event_name} (Date: {event_date})", workbook.add_format({'align': 'center', 'bold': True, 'font_size': 12}))

        header_format = workbook.add_format({'bold': True, 'bg_color': '#D7E4BC', 'border': 1, 'align': 'center'})

        headers = ['Ticket ID', 'Price', 'Schedule ID', 'Image', 'Slot', 'Slot Sold', 'Category']
        worksheet.write_row('A4', headers, header_format)

        for row_num, row_data in enumerate(df[['ticket_id', 'price', 'schedule_id', 'image', 'slot', 'slot_sold', 'category']].values, start=4):
            worksheet.write_row(row_num, 0, row_data)

        worksheet.set_column('A:A', 15)  
        worksheet.set_column('B:B', 10)  
        worksheet.set_column('C:C', 15)  
        worksheet.set_column('D:D', 15)  
        worksheet.set_column('E:E', 10)  
        worksheet.set_column('F:F', 10)  
        worksheet.set_column('G:G', 15)  

        worksheet.freeze_panes(4, 0)

        total_sales = sales_data.get('total_sales', 0)
        summary_format = workbook.add_format({'bold': True, 'bg_color': '#FFD700', 'border': 1, 'align': 'center'})
        worksheet.write(len(df) + 5, 0, 'Total Sales:', summary_format)
        worksheet.write(len(df) + 5, 1, total_sales, summary_format)

        pie_chart_sheet = workbook.add_worksheet('Category Sales Chart')

        category_sales = sales_data.get('category_sales', {})
        if category_sales:
            chart = workbook.add_chart({'type': 'pie'})
            chart.set_title({'name': 'Category Sales Distribution'})

            categories = list(category_sales.keys())
            sales_values = list(category_sales.values())

            pie_chart_sheet.write_column('A1', categories)
            pie_chart_sheet.write_column('B1', sales_values)

            chart.add_series({
                'categories': ['Category Sales Chart', 0, 0, len(categories) - 1, 0],
                'values': ['Category Sales Chart', 0, 1, len(sales_values) - 1, 1],
                'name': 'Sales by Category'
            })

            pie_chart_sheet.insert_chart('D2', chart)

        writer.close()

        logging.info("Excel report generated successfully")
        print("Excel report generated and saved as 'sales_report.xlsx'.")
        print(f"File is available at: {os.path.abspath('sales_report.xlsx')}")

    except Exception as e:
        logging.error(f"Error generating Excel report: {e}")
        print(f"An error occurred while generating the Excel report: {e}")

login()